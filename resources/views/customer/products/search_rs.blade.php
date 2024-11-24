@extends('layouts.customer')

@section('content')
<title>Tìm kiếm sản phẩm</title>
    <div class="container my-5">
        <h2 class="mb-4">Kết quả tìm kiếm cho "{{ $query }}"</h2>

        @if ($products->count() > 0)
            <div class="row justify-content-center"> <!-- Căn giữa các sản phẩm -->
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4 d-flex justify-content-center"> <!-- Căn giữa mỗi ô sản phẩm -->
                        <div class="card product-card h-100">
                            <div class="image-container">
                                <a href="{{ route('customer.products.show', $product->id) }}">
                                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column text-center">
                                <a href="{{ route('customer.products.show', $product->id) }}" class="card-title">
                                    {{ $product->name }}
                                </a>
                                <p class="price"><strong>Giá:</strong> {{ number_format($product->price, 0, '.', ',') }} đ</p>
                                <p class="quantity"><strong>Còn:</strong> {{ $product->quantity }}</p>
                                <p class="category"><strong>Danh mục:</strong> {{ $product->category->name }}</p>

                                <div class="mt-auto d-flex justify-content-center"> <!-- Căn giữa nút -->
                                    <!-- Form thêm vào giỏ hàng -->
                                    <form action="{{ route('customer.cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary add-to-cart product-btn">
                                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $products->links() }} <!-- Hiển thị phân trang -->
        @else
            <p class="text-center">Không tìm thấy sản phẩm nào.</p>
        @endif
    </div>

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
            cursor: pointer; /* Thay đổi con trỏ khi hover */
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

        /* Chỉnh kích thước và căn giữa text */
        .card-title {
            font-size: 1rem; /* Kích thước nhỏ hơn */
            font-weight: 600; /* Giữ độ đậm */
            margin: 0.2rem 0; /* Khoảng cách giữa các phần text giảm */
            text-decoration: none; /* Bỏ gạch chân cho tên sản phẩm */
        }

        .price,
        .quantity,
        .category {
            font-size: 1rem; /* Kích thước đồng nhất cho các phần text */
            margin: 0.2rem 0; /* Khoảng cách giữa các phần text giảm */
        }

        .price {
            font-weight: bold;
            color: #e74c3c; /* Màu đỏ cho giá */
        }

        .card-body {
            padding: 1.5rem; /* Khoảng cách giữa các phần trong card */
            display: flex;
            flex-direction: column; /* Chỉnh bố cục dọc */
            text-align: center; /* Căn giữa nội dung trong card */
        }

        .product-btn {
            transition: background-color 0.3s ease, transform 0.3s ease; /* Hiệu ứng chuyển màu nền và phóng to */
        }

        /* Nút thêm vào giỏ hàng màu xanh nước biển */
        .btn-primary {
            background-color: #007bff; /* Màu xanh nước biển */
            border-color: #007bff;
            color: #fff;
            width: 100%; /* Đảm bảo nút chiếm toàn bộ chiều rộng */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Màu khi hover */
            border-color: #0056b3;
            transform: scale(1.05); /* Phóng to khi hover */
        }

        /* Điều chỉnh responsive */
        @media (max-width: 768px) {
            .product-card {
                margin-bottom: 20px; /* Khoảng cách giữa các card */
            }
        }
    </style>
@endsection
