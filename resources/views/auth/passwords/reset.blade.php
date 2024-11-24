@extends('layouts.customer')

@section('title', 'Đặt Lại Mật Khẩu')

@section('content')
<title>Đặt lại mật khẩu</title>
<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <h1 class="text-center mb-4">Đặt Lại Mật Khẩu</h1>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group mb-3">
                <label for="email">Địa chỉ Email</label>
                <input type="email" name="email" value="{{ $email }}" class="form-control" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="password">Mật khẩu mới</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <div class="form-group mb-4">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Đặt lại mật khẩu</button>
        </form>
    </div>
</div>
@endsection

<style>
    body {
        background-color: #f8f9fa;
        height: 100vh; /* Đảm bảo chiều cao toàn bộ trang */
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

    .btn-primary:hover {
        background-color: #0056b3; /* Màu sắc khi hover */
    }
</style>
