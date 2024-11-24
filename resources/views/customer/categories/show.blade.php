<!-- resources/views/categories/show.blade.php -->
@extends('layouts.customer')

@section('title', 'Category Details')

@section('content')
<title>Chi tiết danh mục</title>
    <h1>Category Details</h1>

    <p><strong>Name:</strong> {{ $category->name }}</p>

    <!-- Hiển thị hãng sản xuất nếu có -->
    <p><strong>Manufacturer:</strong> {{ $category->manufacturer ?? 'N/A' }}</p>

    <!-- Các nút điều hướng -->
    <a href="{{ route('customer.categories.index') }}" class="btn btn-secondary">Back</a>

@endsection
