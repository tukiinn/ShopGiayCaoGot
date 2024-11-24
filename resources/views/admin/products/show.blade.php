<!-- resources/views/admin/products/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
    <h1>Chi Tiết Sản Phẩm</h1>

    @if($product->image)
        <p><strong>Hình Ảnh:</strong></p>
        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" width="200">
    @else
        <p><strong>Hình Ảnh:</strong> Không có hình ảnh</p>
    @endif

    <p><strong>Tên:</strong> {{ $product->name }}</p>
    <p><strong>Mô Tả:</strong> {{ $product->description }}</p>
    <p><strong>Số Lượng:</strong> {{ $product->quantity }}</p>
    <p><strong>Giá:</strong> {{ number_format($product->price, 0, '.', ',') }} đ</p>
    <p><strong>Danh Mục:</strong> {{ $product->category->name }}</p>

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay Về Danh Sách</a>
    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Chỉnh Sửa Sản Phẩm</a>

    <!-- Nút xóa sản phẩm -->
    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">Xóa Sản Phẩm</button>
    </form>
@endsection
