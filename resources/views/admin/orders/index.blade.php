@extends('layouts.admin')

@section('title', 'Quản lý Đơn Hàng')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-4">Quản lý Đơn Hàng</h1>

    <!-- Dropdown chọn phương thức thanh toán, trạng thái và cách sắp xếp -->
    <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-3">
        <div class="form-row align-items-end">
            <div class="col-auto">
                <label for="sort_by_date">Sắp xếp theo ngày:</label>
                <select name="sort_by_date" id="sort_by_date" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option value="">Chọn cách sắp xếp</option>
                    <option value="asc" {{ request('sort_by_date') == 'asc' ? 'selected' : '' }}>Từ sớm nhất</option>
                    <option value="desc" {{ request('sort_by_date') == 'desc' ? 'selected' : '' }}>Từ muộn nhất</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="payment_method">Chọn phương thức thanh toán:</label>
                <select name="payment_method" id="payment_method" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option value="">Tất cả phương thức</option>
                    <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Thanh Toán Khi Nhận Hàng (COD)</option>
                    <option value="momo" {{ request('payment_method') == 'momo' ? 'selected' : '' }}>Thanh Toán Online (MOMO)</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="status">Chọn trạng thái đơn hàng:</label>
                <select name="status" id="status" class="form-control form-control-sm" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đang vận chuyển</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
            </div>
        </div>
    </form>

    @if($orders->isEmpty())
        <p class="text-center text-muted">Không có đơn hàng nào.</p>
    @else
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Khách Hàng</th>
                    <th>Tổng Giá</th>
                    <th>Ngày Đặt</th>
                    <th>Trạng Thái</th>
                    <th>Phương Thức Thanh Toán</th>
                    <th>Yêu Cầu Hủy</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ optional($order->customer)->name ?? 'Khách hàng không xác định' }}</td>
                        <td>{{ number_format($order->total_price, 0, '.', ',') }} đ</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>
                                @if($order->status == 'completed')
                                    <span class="badge badge-success">Đã hoàn thành</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge badge-danger">Đã hủy</span>
                                @else
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
    @if($order->status !== 'paid')
        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang chờ</option>
        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đang vận chuyển</option>
    @endif
    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Đã hoàn thành</option>
    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
</select>

                                    </form>
                                @endif
                            </td>
                            <td>
        @if($order->payment_method === 'cod')
            <span class="badge badge-secondary"><i class="fas fa-truck"></i> Thanh Toán Khi Nhận Hàng (COD)</span>
        @elseif($order->payment_method === 'momo')
            <span class="badge badge-primary"><i class="fas fa-mobile-alt"></i> Thanh Toán Online (MOMO)</span>
        @elseif($order->payment_method === 'momo_qr')
            <span class="badge badge-info"><i class="fas fa-qrcode"></i> Thanh Toán Qua QR (MOMO)</span>
        @else
            <span class="badge badge-dark"><i class="fas fa-question-circle"></i> Không Xác Định</span>
        @endif
</td>


                        <td>
                            @if($order->request_cancel)
                                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">Hủy Đơn Hàng</button>
                                </form>
                            @else
                                Không
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> Xem</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            {{ $orders->links('pagination::bootstrap-4') }}
        </nav>
    </div>
</div>
@endsection
