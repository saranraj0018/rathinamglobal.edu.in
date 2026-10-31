@extends('admin.layout')
@section('title', 'Knowledge')
@section('content')
    <h1>Knowledge documents <a class="btn" href="{{ route('admin.documents.create') }}" style="float:right">New document</a></h1>
    <form method="get" class="card row">
        <div><label>Title</label><input type="search" name="q" value="{{ request('q') }}"></div>
        <div><label>Status</label><select name="status"><option value="">All</option><option @selected(request('status') === 'draft')>draft</option><option @selected(request('status') === 'published')>published</option></select></div>
        <div><button>Filter</button></div>
    </form>
    <div class="card">
        <table>
            <tr><th>Title</th><th>Category</th><th>Lang</th><th>Status</th><th>Updated</th><th></th></tr>
            @forelse ($documents as $document)
                <tr>
                    <td>{{ $document->title }}</td><td>{{ $document->category }}</td><td>{{ strtoupper($document->language) }}</td>
                    <td><span class="badge {{ $document->isPublished() ? 'ok' : 'warn' }}">{{ $document->status }}</span></td>
                    <td>{{ $document->updated_at->diffForHumans() }}</td>
                    <td><a href="{{ route('admin.documents.edit', $document) }}">Edit</a>
                        <form class="inline" method="post" action="{{ route('admin.documents.destroy', $document) }}" onsubmit="return confirm('Delete this document?')">@csrf @method('DELETE') <button class="danger">Delete</button></form></td>
                </tr>
            @empty
                <tr><td colspan="6" class="hint">No documents yet.</td></tr>
            @endforelse
        </table>
        {{ $documents->links() }}
    </div>
@endsection
