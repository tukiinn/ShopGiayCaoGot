@extends('layouts.customer')

@section('title', 'Danh sách sản phẩm')

@section('content')
<title>Danh sách sản phẩm</title>
<h1 class="text-center mb-4" style="font-size: 2.5rem; font-weight: 700; color: #000;">Danh sách sản phẩm</h1>

<style>
    body {
        background-color: #f8f9fa; /* Màu nền sáng */
    }

    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none; /* Bỏ viền card */
        border-radius: 10px; /* Bo tròn góc card */
        overflow: hidden; /* Ẩn phần thừa */
        max-width: 320px; /* Chiều rộng tối đa của card */
        margin: 10px; /* Khoảng cách giữa các card */
    }

    .product-card:hover {
        transform: scale(1.05); /* Phóng to card khi hover */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Đổ bóng */
    }

    .image-container {
        height: 300px; /* Độ cao cho hình ảnh */
        overflow: hidden; /* Ẩn phần thừa */
        display: flex; /* Để căn giữa ảnh */
        align-items: center; /* Căn giữa theo chiều dọc */
        justify-content: center; /* Căn giữa theo chiều ngang */
        background-color: #f8f9fa; /* Màu nền sáng */
    }

    .card-img-top {
        width: 100%; /* Chiều rộng 100% để ảnh nằm vừa trong khung */
        height: auto; /* Giữ tỷ lệ hình ảnh */
        transition: transform 0.3s ease; /* Hiệu ứng chuyển động */
    }

    .product-card:hover .card-img-top {
        transform: scale(1.1); /* Phóng to hình ảnh khi hover */
    }

    .card-body {
        padding: 1rem; /* Khoảng cách giữa các phần trong card */
        text-align: center; /* Căn giữa nội dung trong card */
    }

    .card-body h5 {
        font-size: 1.125rem; /* Kích thước tiêu đề sản phẩm */
        margin-bottom: 0.5rem; /* Khoảng cách dưới */
    }

    .card-body p {
        font-size: 0.9rem; /* Kích thước cho các đoạn văn nhỏ hơn */
        margin-bottom: 0.25rem; /* Giảm khoảng cách giữa các đoạn văn */
    }

    .price {
        font-weight: bold;
        color: #e74c3c; /* Màu đỏ cho giá */
    }

    .product-btn {
        transition: background-color 0.3s ease, transform 0.3s ease; /* Hiệu ứng chuyển màu nền và phóng to */
        width: 100%; /* Đảm bảo nút chiếm toàn bộ chiều rộng */
    }

    .product-btn:hover {
        background-color: #0056b3; /* Màu nền khi hover cho nút "Thêm vào giỏ hàng" */
        transform: scale(1.05); /* Phóng to khi hover */
    }

    /* Điều chỉnh responsive */
    @media (max-width: 768px) {
        .product-card {
            width: 100%; /* Đảm bảo chiều rộng 100% trên thiết bị nhỏ hơn */
        }
    }

</style>

<div class="container">
    <div class="row mb-4 justify-content-start"> <!-- Căn trái hàng -->
        <div class="col-md-6 d-flex align-items-center"> <!-- Sử dụng Flexbox để căn giữa -->
            <!-- Form chọn sắp xếp -->
            <form action="{{ route('customer.products.index') }}" method="GET" class="d-inline-block me-3"> <!-- Thêm khoảng cách bên phải -->
                <label for="sort" class="me-2" style="font-size: 1rem;">Sắp xếp theo:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="form-select form-select-sm" style="display: inline-block; width: auto; font-size: 1rem;">
                    <option value="">Chọn sắp xếp</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên: A đến Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên: Z đến A</option>
                </select>
                <input type="hidden" name="category" value="{{ request('category') }}"> <!-- Giữ giá trị danh mục -->
            </form>

            <!-- Form lọc danh mục -->
            <form action="{{ route('customer.products.index') }}" method="GET" class="d-inline-block">
                <select name="category" id="category" onchange="this.form.submit()" class="form-select" style="font-size: 1rem;">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="sort" value="{{ request('sort') }}"> <!-- Giữ giá trị sắp xếp -->
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
    @foreach ($products as $product)
        <div class="col-md-4 mb-4 d-flex justify-content-center">
            <!-- Hiển thị sản phẩm -->
            <a href="{{ route('customer.products.show', $product->id) }}" class="text-decoration-none text-dark">
                <div class="card h-100 product-card">
                    <!-- Nội dung card sản phẩm -->
                    <div class="image-container">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="Không có hình ảnh">
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="price"><strong>Giá:</strong> {{ number_format($product->price, 0, '.', ',') }} đ</p>
                        <p><strong>Còn:</strong> {{ $product->quantity }}</p>
                        <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
                        <div class="d-flex justify-content-center">
                            <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary product-btn">
                                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        {{ $products->links('pagination::bootstrap-4') }}
    </nav>
</div>



</div>
@endsection
