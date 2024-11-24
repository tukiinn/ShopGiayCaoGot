@extends('layouts.customer')

@section('content')
<div class="container">
    <title>Trang chủ</title>
    <div class="hero-section text-center py-5" style="background-color: #f0f8ff; border-radius: 10px;">
        <h1 class="display-4" style="font-weight: bold; color: #000;">Chào mừng đến với KiinShop!</h1>
        <p class="lead" style="font-size: 1.25rem; color: #555;">Khám phá sản phẩm chất lượng cao với mức giá hấp dẫn!</p>
        <form action="{{ url('/customer/products') }}" method="GET">
            <button type="submit" class="custom-button">Xem Sản Phẩm</button>
        </form>
    </div>

    <div class="row my-5 text-center">
        <div class="col">
            <h2 style="font-weight: bold; color: #000;">Sản phẩm nổi bật</h2>
            <p style="font-size: 1rem; color: #555;">Chúng tôi cung cấp các sản phẩm tuyệt vời nhất với dịch vụ tốt nhất dành cho khách hàng!</p>
        </div>
    </div>

    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($products->chunk(3) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $product)
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm" style="background-color: #fff; border: 1px solid #ddd;">
                                    <a href="{{ route('customer.products.show', $product->id) }}">
                                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="card-title" style="color: #000;">{{ $product->name }}</h5>
                                        <p class="card-text description">{{ $product->description }}</p>
                                        <p class="card-text price" style="color: #FF5733; font-weight: bold; font-size: 1.2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                                            Giá: {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                        </p>
                                        <form action="{{ route('customer.cart.add', $product->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary product-btn add-to-cart">
                                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" style="left: -5%;">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #000;"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next" style="right: -5%;">
            <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #000;"></span>
            <span class="visually-hidden">Tiếp theo</span>
        </button>
    </div>
</div>

<style>
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: #000; /* Đổi màu mũi tên thành đen */
    }
    .carousel-control-prev,
    .carousel-control-next {
        width: 5%; /* Điều chỉnh kích thước nút */
    }
    .card {
        border: 1px solid #ddd; /* Viền mỏng màu xám cho các ô sản phẩm */
        border-radius: 10px; /* Bo góc cho các ô sản phẩm */
        transition: transform 0.3s;
        background-color: #fff; /* Màu nền trắng cho các ô sản phẩm */
    }
    .card:hover {
        transform: scale(1.05); /* Hiệu ứng phóng to khi hover */
    }
    .description {
        display: -webkit-box;
        -webkit-line-clamp: 1; /* Hiển thị 1 dòng */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis; /* Thêm dấu ... */
        opacity: 0.7; /* Làm mờ phần còn lại */
        color: #555; /* Màu xám nhạt cho mô tả sản phẩm */
    }
</style>

@endsection
