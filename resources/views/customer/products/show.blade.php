@extends('layouts.customer')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<title>Chi tiết sản phẩm</title>
<div class="product-detail-container">
    <div class="row">
        <!-- Cột bên trái: Hiển thị hình ảnh sản phẩm -->
        <div class="col-md-6">
            <div class="product-image-container">
                @if($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow product-image">
                @else
                    <div class="placeholder-image bg-light text-center d-flex align-items-center justify-content-center rounded shadow" style="height: 300px;">
                        <p class="text-muted">Không có hình ảnh</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cột bên phải: Hiển thị thông tin sản phẩm -->
        <div class="col-md-6">
            <div class="product-info-container">
                <h2 class="product-name">{{ $product->name }}</h2>
                <p class="product-category text-muted"><strong>Danh mục:</strong> {{ $product->category->name }}</p>

                <!-- Cải thiện phần mô tả sản phẩm -->
                <div class="product-description mt-4">
    <h5 class="description-title"><i class="fas fa-info-circle"></i> Mô tả sản phẩm</h5>
    <p class="description-content">{!! nl2br(e($product->description)) !!}</p>
</div>


                <!-- Các thông tin khác -->
                <div class="product-details mt-4">
                    <p><i class="fas fa-box"></i> <strong>Số lượng còn lại:</strong> {{ $product->quantity }}</p>
                    <p class="product-price text-danger"><i class="fas fa-tag"></i> <strong>Giá:</strong> {{ number_format($product->price, 0, '.', ',') }} đ</p>
                </div>

                <!-- Nút Thêm vào giỏ hàng -->
                @auth
                    <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" id="buttonAdd" class="btn btn-primary btn-block mt-4 simple-button">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                    </form>
                @else
                    <p class="text-warning mt-4">Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để thêm sản phẩm vào giỏ hàng.</p>
                @endauth

                <!-- Nút Quay lại -->
                <a href="javascript:void(0);" class="btn btn-secondary btn-block mt-3 simple-button" onclick="window.history.back()">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>

                <!-- Nút Đi đến Giỏ hàng -->
                <a href="{{ route('customer.cart.index') }}" class="btn btn-info btn-block mt-3 simple-button">
                    <i class="fas fa-shopping-cart"></i> Đi đến Giỏ hàng
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .product-detail-container {
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .product-image-container img {
        max-width: 80%; /* Giảm kích thước xuống còn 80% chiều rộng */
        height: auto;
        border-radius: 10px;
    }

    .placeholder-image {
        height: 300px;
        background-color: #f8f9fa;
    }

    .product-name {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* Cải thiện mô tả sản phẩm */
    .description-title {
        font-size: 1.25rem;
        color: #2c3e50;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .description-content {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #7f8c8d;
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .product-details {
        font-size: 1.1rem;
        margin-top: 20px;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #e74c3c;
    }

    /* Simple Button Styles */
    .simple-button {
        transition: background-color 0.3s ease-in-out;
    }

    .simple-button:hover {
        background-color: #3498db; /* Thay đổi màu nền khi hover */
        color: #fff; /* Thay đổi màu chữ khi hover */
    }
</style>
@endsection
