@extends('layouts.customer')

@section('content')
<div class="container my-5">
    <title>Chi tiết Đơn Hàng #{{ $order->id }}</title>
    <h2 class="text-center mb-4 text-dark">Chi Tiết Đơn Hàng #{{ $order->id }}</h2> <!-- Updated to text-dark -->

    <div class="row mb-4">
        <div class="col-md-6">
            <h5 class="font-weight-bold"><i class="fas fa-user"></i> Thông Tin Khách Hàng</h5>
            <div class="card p-3 shadow-sm">
                <p><strong>Tên:</strong> <i class="fas fa-user-circle"></i> {{ $order->name }}</p>
                <p><strong>Địa Chỉ:</strong> <i class="fas fa-map-marker-alt"></i> {{ $order->address }}</p>
                <p><strong>Số Điện Thoại:</strong> <i class="fas fa-phone"></i> {{ $order->phone }}</p>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <h5 class="font-weight-bold"><i class="fas fa-credit-card"></i> Thông Tin Thanh Toán</h5>
            <div class="card p-3 shadow-sm">
                <p><strong>Phương Thức Thanh Toán:</strong> 
                    @if($order->payment_method === 'cod')
                        <span class="badge bg-success"><i class="fas fa-money-bill-wave"></i> COD</span>
                    @elseif($order->payment_method === 'momo'||$order->payment_method === 'momo_qr')
                        <span class="badge bg-info"><i class="fab fa-cc-mastercard"></i> MOMO</span>
                    @else
                        <span class="badge bg-secondary">Không Xác Định</span>
                    @endif
                </p>
                <p><strong>Tổng Giá:</strong> <i class="fas fa-tag"></i> {{ number_format($order->total_price, 0, '.', ',') }} đ</p>
                <p><strong>Trạng Thái:</strong> 
                    @switch($order->status)
                        @case('pending')
                            <span class="badge bg-warning"><i class="fas fa-clock"></i> Đang Chờ</span>
                            @break
                        @case('completed')
                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Đã Hoàn Thành</span>
                            @break
                        @case('cancelled')
                            <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Đã Hủy</span>
                            @break
                        @case('confirmed')
                            <span class="badge bg-info"><i class="fas fa-truck"></i> Đang Vận Chuyển</span>
                            @break
                        @case('paid')
                            <span class="badge bg-primary"><i class="fas fa-dollar-sign"></i> Đã Thanh Toán</span>
                            @break
                        @default
                            <span class="badge bg-secondary">Không Xác Định</span>
                    @endswitch
                </p>
            </div>
        </div>
    </div>

    <h5 class="mt-4 font-weight-bold"><i class="fas fa-box"></i> Sản Phẩm Đặt Hàng</h5>
    <table class="table table-bordered table-striped text-center shadow-sm">
        <thead class="table-dark"> <!-- Dark header added here -->
            <tr>
                <th>Ảnh Sản Phẩm</th>
                <th>Sản Phẩm</th>
                <th>Số Lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 80px; height: auto; border-radius: 5px;"/>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->price, 0, '.', ',') }} đ</td>
                    <td>{{ number_format($product->price * $product->pivot->quantity, 0, '.', ',') }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total text-end mb-4">
        <h3>Tổng Cộng: <i class="fas fa-money-bill-wave"></i> {{ number_format($order->total_price, 0, '.', ',') }} đ</h3>
    </div>

    <div class="text-center">
        <a href="{{ route('customer.orders.index') }}" class="btn btn-info mt-3"><i class="fas fa-arrow-left"></i> Quay Lại Danh Sách Đơn Hàng</a>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        background-color: #ffffff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
    }
    .table {
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .table th, .table td {
        vertical-align: middle;
        border: none;
    }
    .total {
        font-weight: bold;
        font-size: 1.5rem;
        color: #28a745;
    }
</style>
@endsection
