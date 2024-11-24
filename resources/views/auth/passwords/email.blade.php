@extends('layouts.customer')

@section('title', 'Quên Mật Khẩu') 
@section('content')
<title>Quên mật khẩu</title>
<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <h1 class="text-center mb-4">Quên Mật Khẩu</h1>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="email">Địa chỉ Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Gửi liên kết đặt lại mật khẩu</button>
        </form>
    </div>
</div>
@endsection

<style>
    body {
        background-color: #f8f9fa; /* Màu nền cho trang */
        height: 100vh; /* Đảm bảo chiều cao toàn bộ trang */
    }

    .card {
        border: none;
        border-radius: 10px; /* Bo góc cho card */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Đổ bóng cho card */
    }

    h1 {
        font-weight: bold; /* Đậm tiêu đề */
        color: #343a40; /* Màu tiêu đề */
    }

    .form-group input {
        max-width: 100%; /* Đảm bảo ô textbox chiếm toàn bộ chiều rộng của card */
    }

    .btn-primary {
        background-color: #007bff; /* Màu nền nút */
        border: none; /* Không viền */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Màu nền khi hover */
    }
</style>
