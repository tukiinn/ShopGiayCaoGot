@extends('layouts.customer')

@section('title', 'Đăng Ký')

@section('content')
<title>Đăng ký</title>
<div class="container mt-5 d-flex justify-content-center align-items-center flex-column">
    <h1 class="text-center mb-4">Đăng Ký</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <form id="registerForm" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và Tên:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Địa chỉ Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Xác nhận Mật khẩu:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" id="buttonRegister" class="btn btn-primary btn-block">Đăng Ký</button>
            </form>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}" class="btn btn-secondary">Bạn đã có tài khoản? Đăng Nhập</a>
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
        margin-top: 20px;
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

    .alert {
        margin-bottom: 1rem; /* Đảm bảo có khoảng cách với các phần tử khác */
    }
</style>
@endsection
