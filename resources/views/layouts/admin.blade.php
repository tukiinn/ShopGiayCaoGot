<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
             .alert {
    border-radius: 10px; /* Bo góc cho thông báo */
    padding: 15px; /* Thêm padding */
    margin: 0 auto 20px; /* Đặt khoảng cách bên dưới và căn giữa */
    position: fixed; /* Đặt vị trí cố định */
    top: -100px; /* Đặt thông báo bên ngoài màn hình */
    left: 50%; /* Căn giữa theo chiều ngang */
    transform: translateX(-50%); /* Căn giữa chính xác */
    animation: slideDown 0.5s forwards, fadeIn 0.5s forwards; /* Hiệu ứng trượt xuống và mờ dần */
    z-index: 1000; /* Đảm bảo thông báo hiển thị trên các phần tử khác */
    width: 80%; /* Chiều rộng 80% so với chiều rộng của cửa sổ */
    max-width: 600px; /* Chiều rộng tối đa để tránh quá dài */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Tạo hiệu ứng đổ bóng nhẹ */
    white-space: nowrap; /* Ngăn không cho xuống dòng */
    overflow: hidden; /* Ẩn phần vượt ra ngoài */
    text-overflow: ellipsis; /* Hiệu ứng ... cho văn bản dài */
}

.alert-success {
    background-color: #d4edda; /* Màu nền thành công */
    color: #155724; /* Màu chữ thành công */
    border: 1px solid #c3e6cb; /* Viền cho thông báo thành công */
}

.alert-danger {
    background-color: #f8d7da; /* Màu nền thất bại */
    color: #721c24; /* Màu chữ thất bại */
    border: 1px solid #f5c6cb; /* Viền cho thông báo thất bại */
}

.close {
    position: absolute; /* Định vị nút đóng */
    top: 10px;
    right: 15px;
    color: inherit; /* Kế thừa màu chữ */
    font-size: 1.2em; /* Tăng kích thước nút đóng */
    cursor: pointer; /* Con trỏ khi di chuột lên nút */
    transition: color 0.3s; /* Hiệu ứng chuyển màu khi hover */
}

.close:hover {
    color: #b02a2a; /* Màu chữ khi hover trên nút đóng */
}

/* Hiệu ứng trượt xuống và mờ dần */
@keyframes slideDown {
    0% { top: -100px; opacity: 0; } /* Bắt đầu bên trên và mờ dần */
    100% { top: 20px; opacity: 1; } /* Kết thúc ở vị trí mong muốn và hiển thị đầy đủ */
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
        body {
            background-color: #f9f9f9;
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #333;
        }
        .nav-link {
            color: #555;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #007bff;
            text-decoration: underline;
        }
        .btn-link {
            color: #007bff;
            transition: color 0.3s;
        }
        .btn-link:hover {
            color: #0056b3;
        }
        .container {
    margin-top: 20px;
    border-radius: 10px;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    max-width: 1200px; /* Chiều rộng tối đa */
    margin-left: auto; /* Căn giữa */
    margin-right: auto; /* Căn giữa */
}
    </style>
</head>
<body>

@if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <strong>Thành công!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> <strong>Thất bại!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Quản Trị Viên</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.categories.index') }}">Danh Mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.products.index') }}">Sản Phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">Đơn Hàng</a> <!-- Thêm quản lý đơn hàng -->
                </li>
            </ul>
            <div class="ml-auto">
                <form action="{{ route('logout') }}" method="POST" class="form-inline">
                    @csrf
                    <button type="submit" class="btn btn-link">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Đặt thời gian tự động đóng thông báo sau 5 giây
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000); // 5 giây
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
