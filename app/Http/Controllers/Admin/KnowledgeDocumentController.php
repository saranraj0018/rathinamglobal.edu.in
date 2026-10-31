<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeDocument;
use App\Services\Assistant\DocumentTextExtractor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;

class KnowledgeDocumentController extends Controller
{
    public function index(Request $request): View
    {
        $documents = KnowledgeDocument::query()
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.addcslashes($request->string('q')->toString(), '%_\\').'%'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->latest('updated_at')->paginate(20)->withQueryString();

        return view('admin.documents.index', ['documents' => $documents]);
    }

    public function create(): View
    {
        return view('admin.documents.form', ['document' => new KnowledgeDocument(['language' => 'en', 'status' => KnowledgeDocument::STATUS_DRAFT])]);
    }

    public function store(Request $request, DocumentTextExtractor $extractor): RedirectResponse
    {
        $document = new KnowledgeDocument($this->validated($request, $extractor));
        $document->created_by = $document->updated_by = $request->user()->id;
        $document->save();

        return redirect()->route('admin.documents.index')->with('status', 'Document saved'.($document->isPublished() ? ' and indexed.' : ' as a draft.'));
    }

    public function edit(KnowledgeDocument $document): View
    {
        return view('admin.documents.form', ['document' => $document]);
    }

    public function update(Request $request, KnowledgeDocument $document, DocumentTextExtractor $extractor): RedirectResponse
    {
        $document->fill($this->validated($request, $extractor, $document));
        $document->updated_by = $request->user()->id;
        $document->save();

        return redirect()->route('admin.documents.index')->with('status', 'Document updated and re-indexed.');
    }

    public function destroy(KnowledgeDocument $document): RedirectResponse
    {
        $document->delete();

        return redirect()->route('admin.documents.index')->with('status', 'Document deleted and removed from the assistant.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, DocumentTextExtractor $extractor, ?KnowledgeDocument $existing = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'category' => ['required', 'in:'.implode(',', KnowledgeDocument::CATEGORIES)],
            'language' => ['required', 'in:en,ta'],
            'content' => [$request->hasFile('file') || $existing ? 'nullable' : 'required', 'string', 'max:200000'],
            'keywords' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'in:draft,published'],
            'file' => ['nullable', 'file', 'mimes:pdf,docx,txt', 'max:10240'],
        ]);

        if ($request->hasFile('file')) {
            try {
                $extracted = $extractor->extract($request->file('file'));
            } catch (RuntimeException $e) {
                throw ValidationException::withMessages(['file' => $e->getMessage()]);
            }

            $data['content'] = trim(($data['content'] ?? '')."\n\n".$extracted);
            $data['source_file'] = $request->file('file')->getClientOriginalName();
        }

        $data['content'] ??= $existing?->content;
        unset($data['file']);

        return $data;
    }
}
