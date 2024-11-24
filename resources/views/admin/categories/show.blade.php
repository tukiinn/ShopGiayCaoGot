<!-- resources/views/admin/categories/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
    <h1>Category Details</h1>

    <p><strong>Name:</strong> {{ $category->name }}</p>

    <!-- Hiển thị hãng sản xuất nếu có -->
    <p><strong>Manufacturer:</strong> {{ $category->manufacturer ?? 'N/A' }}</p>

    <!-- Các nút điều hướng -->
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to Category List</a>
    
    <!-- Nút chỉnh sửa danh mục -->
    @auth
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Edit Category</a>

            <!-- Nút xóa danh mục -->
            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete Category</button>
            </form>
        @endif
    @endauth
@endsection
