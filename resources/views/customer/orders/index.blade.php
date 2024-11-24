@extends('layouts.customer')

@section('content')
<div class="container my-5">
    <title>Danh Sách Đơn Hàng</title>
    <h2 class="text-center mb-4"><i class="fas fa-list"></i> Danh Sách Đơn Hàng</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            Bạn chưa có đơn hàng nào.
        </div>
    @else
        <table class="table table-hover table-striped text-center shadow-sm rounded">
            <thead class="bg-dark text-white"> 
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Tên Người Nhận</th>
                    <th>Địa Chỉ</th>
                    <th>Số Điện Thoại</th>
                    <th>Phương Thức Thanh Toán</th>
                    <th>Tổng Giá</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><strong>{{ $order->id }}</strong></td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>
                            @if($order->payment_method === 'cod')
                                <span class="badge bg-success"><i class="fas fa-money-bill-wave"></i> COD</span>
                            @elseif($order->payment_method === 'momo'||$order->payment_method === 'momo_qr')
                                <span class="badge bg-info"><i class="fab fa-cc-mastercard"></i> MOMO</span>
                            @else
                                <span class="badge bg-secondary">Không Xác Định</span>
                            @endif
                        </td>
                        <td>{{ number_format($order->total_price, 0, '.', ',') }} đ</td>
                        <td>
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
                        </td>
                        <td>
                            @if($order->request_cancel)
                                <form action="{{ route('customer.orders.cancelRequest', $order->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn hủy yêu cầu hủy đơn hàng này?')">
                                        <i class="fas fa-times"></i> Hủy Yêu Cầu
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('customer.orders.requestCancel', $order->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Bạn có chắc muốn gửi yêu cầu hủy đơn hàng này?')">
                                        <i class="fas fa-exclamation-triangle"></i>Yêu Cầu Hủy
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-info-circle"></i> Chi Tiết
                            </a>

                            @if($order->status === 'pending' && in_array($order->payment_method, ['momo', 'vnpay', 'momo_qr']))
    <form action="{{ route('customer.payment.retry', $order->id) }}" method="POST" style="display:inline-block;">
        @csrf
        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Đi đến thanh toán đơn hàng này')">
            @if($order->payment_method === 'momo')
                <i class="fab fa-cc-mastercard"></i> Thanh Toán MOMO
            @elseif($order->payment_method === 'vnpay')
                <i class="fas fa-credit-card"></i> Thanh Toán VNPAY
            @elseif($order->payment_method === 'momo_qr')
                <i class="fas fa-qrcode"></i> Thanh Toán QR MOMO
            @endif
        </button>
    </form>
@endif


                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        {{ $orders->links('pagination::bootstrap-4') }}
    </nav>
</div>

<style>
    /* Hiệu ứng hover cho các nút */
    .btn:hover {
        opacity: 0.9; /* Giảm độ trong suốt khi hover */
        transform: translateY(-2px); /* Di chuyển nhẹ lên trên */
        transition: all 0.3s ease; /* Thêm hiệu ứng chuyển động */
    }

    /* Tùy chỉnh cho các nút */
    .btn {
        min-width: 120px; /* Đặt chiều rộng tối thiểu cho các nút */
        border-radius: 5px; /* Bo góc cho các nút */
    }
</style>

@endsection
