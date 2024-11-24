<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS 5.1.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts và Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
       /* CSS chủ đề sáng */
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: #f8f9fa; /* Nền sáng */
    font-family: 'Roboto', sans-serif;
    color: #212529; /* Chữ màu tối */
}

/* Định nghĩa bố cục cho thanh điều hướng */
.navbar {
    background-color: #333; /* Màu nền thanh navbar */
    padding: 15px 20px;
    display: flex;
    justify-content: space-between; /* Căn đều các mục */
    align-items: center; /* Căn giữa theo chiều dọc */
    flex-wrap: wrap; /* Để phần tử con có thể xuống dòng */
}

.navbar-brand {
    color: #fff !important;
    font-size: 2rem;
    font-weight: bold;
    transition: color 0.3s, transform 0.3s;
}

.navbar-brand:hover {
    color: #b3b3b3 !important;
    transform: scale(1.1);
}

/* Điều chỉnh các liên kết trong navbar */
.navbar-nav {
    display: flex;
    flex-direction: row; /* Các nút nằm ngang */
}

.nav-link {
    color: #fff !important;
    font-size: 1.2rem;
    transition: color 0.3s, transform 0.2s;
    margin: 0 10px; /* Khoảng cách giữa các nút */
}

.nav-link:hover {
    color: #b3b3b3 !important;
    text-decoration: underline;
    transform: scale(1.05);
}

/* Đặt thanh tìm kiếm xuống dòng */
.nav-search {
    display: block; /* Để thanh tìm kiếm xuống dòng */
    width: 100%; /* Chiều rộng toàn bộ */
    text-align: center; /* Căn giữa thanh tìm kiếm */
    margin-top: 15px; /* Khoảng cách giữa thanh tìm kiếm và các nút phía trên */
}

.nav-search input[type="search"] {
    padding: 8px 20px;
    font-size: 1rem;
    width: 60%; /* Chiều rộng của thanh tìm kiếm */
    max-width: 400px; /* Độ rộng tối đa */
    border-radius: 20px;
    border: 1px solid #ccc;
    transition: border-color 0.3s;
}

.nav-search input[type="search"]:focus {
    border-color: #007bff; /* Đổi màu viền khi focus */
    outline: none;
}

.nav-separator {
    margin: 0 10px;
    color: #fff;
    font-size: 1.5rem;
}

.user-info {
    color: #f1f1f1;
    margin-right: 10px;
    font-size: 1.2rem;
    align-self: center;
}



main {
    flex: 1;
    margin: 20px auto;
    padding: 30px;
    border-radius: 8px;
    background-color: #fff; /* Nền chính màu trắng */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
    max-width: 1200px;
}

footer {
    background-color: #333; /* Nền footer màu xám đậm */
    color: #fff;
    text-align: center;
    padding: 20px;
}

.footer-link {
    color: #f1f1f1 !important;
    text-decoration: underline;
    transition: color 0.3s;
}

.footer-link:hover {
    color: #b3b3b3 !important; /* Hover trên footer link */
}

/* Tùy chỉnh nút "Xem" */
.btn-info:hover {
    background-color: #007bff; /* Màu nền khi hover cho nút "Xem" */
    transform: scale(1.05); /* Phóng to khi hover */
}

/* Tùy chỉnh thông báo */
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

.alert-warning {
    background-color: #ffc107; /* Màu nền vàng */
    color: #856404; /* Màu chữ tối hơn */
    border: 1px solid #ffeeba; /* Viền cho thông báo cảnh báo */
}


.close {
    position: absolute; /* Định vị nút đóng */
    top: 10px; /* Cách lề trên */
    right: 15px; /* Cách lề phải */
    color: inherit; /* Kế thừa màu chữ */
    font-size: 1.2em; /* Tăng kích thước nút đóng */
    cursor: pointer; /* Con trỏ khi di chuột lên nút */
    background: none; /* Không có nền */
    border: none; /* Không có viền */
    transition: color 0.3s; /* Hiệu ứng chuyển màu khi hover */
}

.close:hover {
    color: #b02a2a; /* Màu chữ khi hover trên nút đóng */
}
.fade-out {
    opacity: 0; /* Đặt độ mờ thành 0 */
    transition: opacity 1s ease; /* Thời gian chuyển đổi */
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

/* Nút thêm vào giỏ hàng */
.add-to-cart {
    background-color: #007bff; /* Màu nền chính */
    color: white; /* Màu chữ */
    border: none; /* Xóa viền */
    border-radius: 5px; /* Bo góc */
    padding: 10px 20px; /* Padding cho nút */
    transition: background-color 0.3s ease, transform 0.3s ease; /* Hiệu ứng chuyển màu và phóng to */
}

.add-to-cart:hover {
    background-color: #0056b3; /* Màu nền khi hover */
    transform: scale(1.05); /* Phóng to khi hover */
}

/* Nút tùy chỉnh */
.custom-button {
    --color: #000000; /* Màu đen cho nút */
    font-family: 'Roboto', sans-serif;
    display: inline-block;
    width: auto; /* Tự động điều chỉnh kích thước */
    padding: 10px 18px; /* Thay đổi padding để giảm chiều rộng */
    height: auto; /* Tự động điều chỉnh chiều cao */
    line-height: 2.5em;
    overflow: hidden;
    cursor: pointer;
    margin: 20px;
    font-size: 17px;
    z-index: 1;
    color: var(--color);
    border: 2px solid var(--color);
    border-radius: 6px;
    position: relative;
    transition: color 0.3s ease; /* Hiệu ứng mượt khi chuyển đổi màu */
}

.custom-button::before {
    position: absolute;
    content: "";
    background: var(--color);
    width: 140px; /* Giảm chiều rộng của hiệu ứng */
    height: 190px; /* Giảm chiều cao của hiệu ứng */
    z-index: -1;
    border-radius: 50%;
    top: 100%;
    left: 100%;
    transition: top 0.3s ease, left 0.3s ease; /* Chuyển đổi mượt */
}

.custom-button:hover {
    color: #909190;
}

.custom-button:hover::before {
    top: -30px;
    left: -30px;
}

        /* Đặt chiều rộng cho ô địa chỉ */
        .table td:nth-child(3), /* Chỉ định ô địa chỉ */
        .table th:nth-child(3) { /* Nếu cần, cũng có thể đặt cho ô tiêu đề */
            max-width: 200px; /* Đặt chiều rộng tối đa cho ô */
            white-space: nowrap; /* Không cho phép nội dung xuống dòng */
            overflow: hidden; /* Ẩn phần nội dung bị tràn */
            text-overflow: ellipsis; /* Hiển thị dấu ba chấm khi nội dung quá dài */
        }
    </style>
</head>
<body>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <strong>Thành công!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('status'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i> <strong>Thông báo:</strong> {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <strong>Thất bại!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">KiinShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.products.index') }}">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.categories.index') }}">Danh mục</a>
                </li>
            </ul>

            <!-- Thông tin người dùng và giỏ hàng -->
            <ul class="navbar-nav align-items-center ms-auto">
                @if (!Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                    </li>
                    @else
    <li class="nav-item">
        <span class="user-info">Xin chào, {{ Auth::user()->name }}</span>
    </li>
    <li class="nav-item">
        <span class="nav-separator">|</span>
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
    <li class="nav-item nav-cart">
    <a class="nav-link" href="{{ route('customer.cart.index') }}" data-toggle="tooltip" title="Giỏ hàng">
        <i class="fas fa-shopping-cart"></i>
        <span class="badge bg-danger" style="position: relative; top: -10px; left: -5px; font-size: 12px; padding: 3px 6px; line-height: 1;">
    {{ $cartCount }}
</span>
    </a>
</li>
<li class="nav-item nav-orders">
    <a class="nav-link" href="{{ route('customer.orders.index') }}" data-toggle="tooltip" title="Đơn hàng">
        <i class="fas fa-box"></i> <!-- Biểu tượng cho quản lý đơn hàng -->
        <span class="badge bg-primary" style="position: relative; top: -10px; left: -5px; font-size: 12px; padding: 3px 6px; line-height: 1;">
            {{ $orderCount }}
        </span>
    </a>
</li>

@endif

            </ul>
        </div>

        <!-- Thanh tìm kiếm -->
        <div class="search-bar w-100 mt-3">
            <form class="d-flex justify-content-center" action="{{ route('customer.products.search') }}" method="GET">
                <input class="form-control me-2 w-50" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" required>
                <button class="btn btn-outline-success" type="submit">Tìm kiếm</button>
            </form>
        </div>
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

<footer>
    <p>&copy; {{ date('Y') }} Công ty KiinShop. Tất cả quyền được bảo lưu.
        <a href="#" class="footer-link">Điều khoản dịch vụ</a> |
        <a href="#" class="footer-link">Chính sách bảo mật</a>
    </p>
</footer>

<!-- Thư viện jQuery và Bootstrap Bundle -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Đặt thời gian tự động đóng thông báo sau 5 giây
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000); // 5 giây
    });
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

</script>

</body>
</html>
