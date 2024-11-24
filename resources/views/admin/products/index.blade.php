<!-- resources/views/admin/products/index.blade.php -->

@extends('layouts.admin')

@section('title', 'Danh Sách Sản Phẩm')

@section('content')
    <h1>Danh Sách Sản Phẩm</h1>

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Thêm Sản Phẩm Mới</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Hình Ảnh</th>
                <th>Tên</th>
                <th>Mô Tả</th>
                <th>Số Lượng</th>
                <th>Giá</th>
                <th>Danh Mục</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            Không Có Hình Ảnh
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td class="product-description-scrollable">{{ $product->description }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ number_format($product->price, 0, '.', ',') }} đ</td>
                    <td>{{ $product->category->name }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info">Chi tiết</a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Chỉnh Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <style>
        .product-description-scrollable {
            max-height: 50px; /* Giới hạn chiều cao */
            overflow-y: auto; /* Thêm thanh cuộn dọc */
            padding-right: 10px; /* Đảm bảo nội dung không bị che */
            word-wrap: break-word; /* Tự động xuống dòng khi gặp từ dài */
            max-width: 200px; /* Giới hạn chiều rộng */
            border: 1px solid #ccc; /* Thêm viền */
            padding: 5px; /* Thêm khoảng cách */
            background-color: #f9f9f9; /* Màu nền cho mô tả */
        }

        .product-image {
            width: 50px; /* Kích thước hình ảnh sản phẩm */
            height: auto; /* Giữ tỷ lệ hình ảnh */
            border-radius: 5px; /* Bo góc hình ảnh */
            border: 1px solid #ddd; /* Viền cho hình ảnh */
        }

        /* Căn chỉnh các nút hành động cho đồng đều */
        .action-buttons a, 
        .action-buttons button {
            width: 100px; /* Đặt cùng chiều rộng */
            margin: 2px; /* Khoảng cách giữa các nút */
            text-align: center; /* Căn giữa văn bản trong nút */
        }

        /* Đặt chiều cao cho các nút */
        .action-buttons .btn {
            height: 40px; /* Đặt chiều cao */
            display: inline-flex; /* Căn giữa văn bản trong nút */
            justify-content: center;
            align-items: center;
        }

        /* Định dạng bảng */
        table {
            border-collapse: collapse; /* Bỏ viền giữa các ô */
            width: 100%; /* Chiếm toàn bộ chiều rộng */
        }

        th, td {
            padding: 10px; /* Khoảng cách trong các ô */
            vertical-align: middle; /* Căn giữa dọc */
            border: 1px solid #dee2e6; /* Viền bảng */
        }

        th {
            background-color: #f2f2f2; /* Màu nền cho tiêu đề bảng */
        }

        tbody tr:hover {
            background-color: #f5f5f5; /* Màu nền khi hover */
        }
    </style>
@endsection
