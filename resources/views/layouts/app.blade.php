<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang chủ')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background-color: #6f42c1;
        }
        .navbar-brand {
            color: #fff !important;
            font-size: 2rem;
            font-weight: bold;
        }
        .navbar-brand:hover {
            color: #ffd600 !important;
            transform: scale(1.1);
        }
        .nav-link {
            color: #fff !important;
            font-size: 1.5rem;
        }
        .nav-link:hover {
            color: #ffd600 !important;
        }
        .nav-item .hover-text {
            position: absolute;
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            top: 50px;
            right: 0;   
            display: none;
            font-size: 0.95rem;
        }
        .nav-item:hover .hover-text {
            display: block;
        }
        main {
            flex: 1;
            margin: 20px auto;
            padding: 30px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }
        footer {
            background-color: #6f42c1;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: auto;
        }
        footer .footer-link {
            color: #fff !important;
            text-decoration: underline;
            transition: color 0.3s;
        }
        footer .footer-link:hover {
            color: #ffd600 !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('customer.products.index') }}">Cửa hàng</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Giỏ hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Đăng xuất
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-shopping-cart"></i> 
                            <span class="hover-text">Đăng nhập để xem giỏ hàng</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }} Công ty Của Bạn. Tất cả quyền được bảo lưu. 
        <a href="#" class="footer-link">Điều khoản dịch vụ</a> | 
        <a href="#" class="footer-link">Chính sách bảo mật</a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
