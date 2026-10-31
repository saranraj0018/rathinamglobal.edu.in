@extends('admin.layout')
@section('title', 'FAQ categories')
@section('content')
    <h1>FAQ categories</h1>
    <form method="post" action="{{ route('admin.categories.store') }}" class="card row">
        @csrf
        <div><label>Name (English)</label><input type="text" name="name_en" required></div>
        <div><label>Name (Tamil)</label><input type="text" name="name_ta"></div>
        <div><label>Order</label><input type="number" name="sort_order" value="0"></div>
        <div><button>Add category</button></div>
    </form>
    @foreach ($errors->all() as $message)<div class="error">{{ $message }}</div>@endforeach
    <div class="card">
        <table>
            <tr><th>English</th><th>Tamil</th><th>Order</th><th>Active</th><th>FAQs</th><th></th></tr>
            @foreach ($categories as $category)
                <tr>
                    <form method="post" action="{{ route('admin.categories.update', $category) }}">@csrf @method('PUT')
                        <td><input type="text" name="name_en" value="{{ $category->name_en }}"></td>
                        <td><input type="text" name="name_ta" value="{{ $category->name_ta }}"></td>
                        <td><input type="number" name="sort_order" value="{{ $category->sort_order }}" style="width:80px"></td>
                        <td><input type="checkbox" name="is_active" value="1" @checked($category->is_active)></td>
                        <td>{{ $category->faqs_count }}</td>
                        <td><button class="alt">Save</button></td>
                    </form>
                    <td><form class="inline" method="post" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="danger">Delete</button></form></td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
