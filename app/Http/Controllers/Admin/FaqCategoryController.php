<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class FaqCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories', ['categories' => FaqCategory::withCount('faqs')->orderBy('sort_order')->orderBy('name_en')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        FaqCategory::create($data + ['slug' => $this->uniqueSlug($data['name_en'])]);

        return back()->with('status', 'Category added.');
    }

    public function update(Request $request, FaqCategory $category): RedirectResponse
    {
        $category->update($this->validated($request));

        return back()->with('status', 'Category updated.');
    }

    public function destroy(FaqCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('status', 'Category deleted. Its FAQs are now uncategorised.');
    }

    /**
     * @return array{name_en: string, name_ta: ?string, sort_order: int, is_active: bool}
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:120'],
            'name_ta' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65000'],
        ]);

        return [
            'name_en' => $data['name_en'],
            'name_ta' => $data['name_ta'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active', true),
        ];
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name) ?: 'category';

        return FaqCategory::where('slug', $slug)->exists() ? $slug.'-'.Str::lower(Str::random(4)) : $slug;
    }
}
