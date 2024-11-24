@extends('layouts.admin')

@section('title', 'Chi Tiết Đơn Hàng #' . $order->id)

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4">
        <i class="fas fa-receipt"></i> Chi Tiết Đơn Hàng #{{ $order->id }}
    </h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fas fa-user"></i> Thông Tin Khách Hàng
            </h5>
            <p><strong><i class="fas fa-user-tag"></i> Tên:</strong> {{ $order->name ?? 'N/A' }}</p>
            <p><strong><i class="fas fa-map-marker-alt"></i> Địa Chỉ:</strong> {{ $order->address }}</p>
            <p><strong><i class="fas fa-phone"></i> Số Điện Thoại:</strong> {{ $order->phone }}</p>
            <p><strong><i class="fas fa-calendar-alt"></i> Ngày Đặt:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong><i class="fas fa-info-circle"></i> Trạng Thái:</strong> 
                @switch($order->status)
                    @case('pending')
                        Đang chờ
                        @break
                    @case('confirmed')
                        Đã xác nhận
                        @break
                    @case('completed')
                        Đã hoàn thành
                        @break
                    @case('paid')
                        Đã thanh toán
                        @break
                    @case('cancelled')
                        Đã hủy
                        @break
                    @default
                        Không xác định
                @endswitch
            </p>
            <p><strong><i class="fas fa-credit-card"></i> Phương Thức Thanh Toán:</strong> {{ $order->payment_method }}</p> <!-- Hiển thị phương thức thanh toán -->

            <h5 class="mt-4">
                <i class="fas fa-box-open"></i> Chi Tiết Đơn Hàng
            </h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><i class="fas fa-box"></i> Sản Phẩm</th>
                        <th><i class="fas fa-sort-amount-up-alt"></i> Số Lượng</th>
                        <th><i class="fas fa-tag"></i> Giá</th>
                        <th><i class="fas fa-money-bill-wave"></i> Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @if($order->products && $order->products->isNotEmpty())
                        @foreach($order->products as $product)
                            <tr>
                                <td>
                                    <img src="{{ asset('images/'.$product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                                    {{ $product->name }} <!-- Di chuyển tên sản phẩm vào cột ảnh -->
                                </td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>{{ number_format($product->price, 0, '.', ',') }} đ</td>
                                <td>{{ number_format($product->price * $product->pivot->quantity, 0, '.', ',') }} đ</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Không có sản phẩm nào trong đơn hàng.</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong><i class="fas fa-calculator"></i> Tổng Cộng:</strong></td>
                        <td>{{ number_format($order->total_price, 0, '.', ',') }} đ</td>
                    </tr>
                </tfoot>
            </table>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>
</div>
@endsection
