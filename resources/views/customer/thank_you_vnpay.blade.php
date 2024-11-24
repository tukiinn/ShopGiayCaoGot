<!-- resources/views/customer/thank_you_vnpay.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-success">
        <h4>Cảm ơn bạn đã thanh toán!</h4>
        <p>Giao dịch của bạn đã được xử lý thành công.</p>
        <p>Mã đơn hàng: {{ $orderId }}</p>
    </div>
    <a href="{{ route('customer.orders.index') }}" class="btn btn-primary">Quay về trang đơn hàng</a>
</div>
@endsection
