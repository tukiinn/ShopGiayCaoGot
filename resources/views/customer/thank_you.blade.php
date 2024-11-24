@extends('layouts.customer')

@section('content')
<title>Cảm ơn đã đặt hàng</title>
    <div class="container">
        <h1>Cảm ơn bạn đã thanh toán!</h1>
        <p>Thanh toán của bạn đã được xử lý thành công.</p>
        <a href="{{ route('customer.orders.index') }}" class="btn btn-primary">Quay lại trang đơn hàng</a>
    </div>



</div>
@endsection
