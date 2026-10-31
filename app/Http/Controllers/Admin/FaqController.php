<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssistantMessage;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $faqs = Faq::query()->with('category')
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => collect(['question_en', 'answer_en', 'question_ta', 'answer_ta', 'keywords', 'variations'])
                ->each(fn (string $column) => $w->orWhere($column, 'like', '%'.addcslashes($search, '%_\\').'%'))))
            ->when($request->filled('category'), fn ($q) => $q->where('faq_category_id', $request->integer('category')))
            ->when($request->string('status')->toString() === 'published', fn ($q) => $q->live())
            ->when($request->string('status')->toString() === 'draft', fn ($q) => $q->whereNull('published_at'))
            ->when($request->string('status')->toString() === 'disabled', fn ($q) => $q->where('is_active', false))
            ->latest('id')->paginate(20)->withQueryString();

        return view('admin.faqs.index', ['faqs' => $faqs, 'categories' => FaqCategory::orderBy('name_en')->get()]);
    }

    public function create(Request $request): View
    {
        $faq = new Faq(['is_active' => true, 'question_en' => $request->query('question')]);
        $source = $request->query('from_message');

        return view('admin.faqs.form', [
            'faq' => $faq,
            'categories' => FaqCategory::orderBy('name_en')->get(),
            'fromMessage' => $source ? AssistantMessage::find($source) : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $faq = new Faq($this->validated($request));
        $faq->created_by = $faq->updated_by = $request->user()->id;
        $faq->save();

        if ($request->filled('from_message')) {
            AssistantMessage::whereKey($request->integer('from_message'))->update(['resolved_at' => now()]);
        }

        return redirect()->route('admin.faqs.index')->with('status', 'FAQ saved and indexed for the assistant.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.form', ['faq' => $faq, 'categories' => FaqCategory::orderBy('name_en')->get(), 'fromMessage' => null]);
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $faq->fill($this->validated($request, $faq));
        $faq->updated_by = $request->user()->id;
        $faq->save();

        return redirect()->route('admin.faqs.index')->with('status', 'FAQ updated and re-indexed.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('status', 'FAQ deleted and removed from the assistant.');
    }

    /**
     * Bulk import from CSV with the header: category,question_en,answer_en,question_ta,answer_ta,keywords,variations
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt', 'max:2048']]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $header = array_map(fn ($h) => Str::lower(trim((string) $h, "\xEF\xBB\xBF \t")), (array) fgetcsv($handle));
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $row = array_combine($header, array_pad($row, count($header), null)) ?: [];
            $hasEnglish = filled($row['question_en'] ?? null) && filled($row['answer_en'] ?? null);
            $hasTamil = filled($row['question_ta'] ?? null) && filled($row['answer_ta'] ?? null);

            if (! $hasEnglish && ! $hasTamil) {
                continue;
            }

            $category = filled($row['category'] ?? null)
                ? FaqCategory::firstOrCreate(['name_en' => trim($row['category'])], ['slug' => Str::slug($row['category']).'-'.Str::lower(Str::random(4))])
                : null;

            $faq = new Faq(collect($row)->only(['question_en', 'answer_en', 'question_ta', 'answer_ta', 'keywords', 'variations'])->all());
            $faq->faq_category_id = $category?->id;
            $faq->is_active = true;
            $faq->published_at = now();
            $faq->created_by = $faq->updated_by = $request->user()->id;
            $faq->save();
            $imported++;
        }

        fclose($handle);

        return back()->with('status', "{$imported} FAQs imported and published.");
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?Faq $existing = null): array
    {
        $data = $request->validate([
            'faq_category_id' => ['nullable', 'exists:faq_categories,id'],
            'question_en' => ['nullable', 'string', 'max:1000'],
            'answer_en' => ['nullable', 'string', 'max:5000'],
            'question_ta' => ['nullable', 'string', 'max:1000'],
            'answer_ta' => ['nullable', 'string', 'max:5000'],
            'keywords' => ['nullable', 'string', 'max:1000'],
            'variations' => ['nullable', 'string', 'max:3000'],
        ]);

        $hasEnglish = filled($data['question_en'] ?? null) && filled($data['answer_en'] ?? null);
        $hasTamil = filled($data['question_ta'] ?? null) && filled($data['answer_ta'] ?? null);

        if (! $hasEnglish && ! $hasTamil) {
            $request->validate(['question_en' => ['required_without:question_ta'], 'answer_en' => ['required_with:question_en'], 'answer_ta' => ['required_with:question_ta']]);
        }

        return $data + [
            'is_active' => $request->boolean('is_active'),
            'published_at' => $request->boolean('published') ? ($existing?->published_at ?? now()) : null,
        ];
    }
}
