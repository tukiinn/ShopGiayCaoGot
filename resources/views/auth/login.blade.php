@extends('layouts.customer')

@section('title', 'Đăng Nhập')

@section('content')
<title>Đăng nhập</title>
<div class="container mt-5 d-flex justify-content-center align-items-center flex-column">
    <h1 class="text-center mb-4">Đăng Nhập</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('login') }}" method="POST" id="loginForm">  
                @csrf
                <div class="form-group">
                    <label for="userEmail">Địa chỉ Email:</label>
                    <input type="email" name="email" id="userEmail" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="userPassword">Mật khẩu:</label>
                    <input type="password" name="password" id="userPassword" class="form-control" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="remember" id="rememberMe" class="form-check-input">
                    <label for="rememberMe" class="form-check-label">Nhớ mật khẩu</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block" id="loginButton">Đăng Nhập</button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ url('/password/reset') }}" class="btn btn-secondary">Quên mật khẩu?</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Bạn chưa có tài khoản? Đăng ký</a>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
        height: 100vh; /* Đảm bảo chiều cao toàn bộ trang */
    }

   

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%; /* Đảm bảo card chiếm toàn bộ chiều rộng */
        max-width: 400px; /* Giới hạn chiều rộng tối đa của card */
    }

    .card-body {
        padding: 2rem;
    }

    h1 {
        font-weight: bold;
        color: #343a40;
    }

    .form-group input {
        max-width: 100%; /* Đảm bảo ô textbox chiếm toàn bộ chiều rộng của card */
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>
@endsection