@extends('layouts.customer')

@section('content')
<div class="container my-5">
    <title>Giỏ hàng</title>
    <h2 class="text-center mb-4"><i class="fas fa-shopping-cart"></i> Giỏ Hàng Của Bạn</h2>
    
    @if($carts->isEmpty())
        <p class="text-center">Giỏ hàng của bạn hiện đang trống.</p>
    @else
    <div class="table-responsive">
    <table class="table text-center" style="border: none;">
        <thead class="table-dark" style="border: none;">
            <tr>
                <th></th>
                <th></th>
                <th class="quantity-col">Số Lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody id="cart-items" style="border: none;">
            @foreach($carts as $cart)
                <tr>
                    <td class="col-2"></td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('customer.products.show', $cart->product->id) }}" class="product-link">
                                <img src="{{ asset('images/' . $cart->product->image) }}" alt="" style="width: 80px; height: auto;"/>
                                <span>{{ $cart->product->name }}</span>
                            </a>
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('customer.cart.update', $cart->id) }}" method="POST" class="d-inline update-form">
                            @csrf
                            @method('PUT')
                            <div class="input-group justify-content-center">
                                <button type="button" class="btn btn-outline-secondary decrease btn-sm" data-id="{{ $cart->id }}" data-max="{{ $cart->product->quantity }}">-</button>
                                <input type="number" id="quantity-{{ $cart->id }}" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->quantity }}" class="form-control quantity-input text-center" style="width: 60px;">
                                <button type="button" class="btn btn-outline-secondary increase btn-sm" data-id="{{ $cart->id }}" data-max="{{ $cart->product->quantity }}">+</button>
                            </div>
                        </form>
                    </td>
                    <td class="price">{{ number_format($cart->product->price, 0, '.', ',') }} đ</td>
                    <td class="total-price">{{ number_format($cart->product->price * $cart->quantity, 0, '.', ',') }} đ</td>
                    <td>
                        <form action="{{ route('customer.cart.remove', $cart->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"> <i class="fas fa-trash-alt"></i> Xóa</button>
                        </form>
                    </td>
                </tr>
                @if($cart->quantity > $cart->product->quantity)
                    <tr>
                        <td colspan="6" class="text-danger">
                            Số lượng {{ $cart->product->name }} vượt quá số lượng trong kho (Chỉ còn {{ $cart->product->quantity }}).
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>

        <div class="total text-end">
            <h3>Tổng Cộng: <span id="total-amount">{{ number_format($carts->sum(function($cart) { return $cart->product->price * $cart->quantity; }), 0, '.', ',') }}</span> đ</h3>
        </div>
       
        <div class="text-center mt-4 d-flex justify-content-center">
    <form action="{{ route('customer.cart.clear') }}" method="POST" class="me-2" onsubmit="return confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"> <i class="fas fa-trash-alt"></i> Xóa Toàn Bộ Giỏ Hàng</button>
    </form>
    <a href="{{ route('customer.cart.payment.form') }}" id="buttonOrder" class="btn btn-success"><i class="fas fa-credit-card"></i> Thanh Toán</a>
</div>

    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tăng số lượng
        document.querySelectorAll('.increase').forEach(button => {
            button.addEventListener('click', function () {
                let cartId = this.getAttribute('data-id');
                let maxQuantity = parseInt(this.getAttribute('data-max'));
                let quantityInput = document.getElementById('quantity-' + cartId);
                let currentQuantity = parseInt(quantityInput.value);

                if (currentQuantity < maxQuantity) {
                    quantityInput.value = currentQuantity + 1;
                    updateCartQuantity(cartId, quantityInput.value);
                }
            });
        });

        // Giảm số lượng
        document.querySelectorAll('.decrease').forEach(button => {
            button.addEventListener('click', function () {
                let cartId = this.getAttribute('data-id');
                let quantityInput = document.getElementById('quantity-' + cartId);
                let currentQuantity = parseInt(quantityInput.value);

                if (currentQuantity > 1) {
                    quantityInput.value = currentQuantity - 1;
                    updateCartQuantity(cartId, quantityInput.value);
                }
            });
        });

        // Cập nhật số lượng khi click ra ngoài
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('blur', function () {
                let cartId = this.id.split('-')[1]; // Lấy ID giỏ hàng từ ID của input
                let quantity = parseInt(this.value);

                // Kiểm tra giá trị hợp lệ
                if (isNaN(quantity) || quantity < 1) {
                    this.value = 1; // Nếu không hợp lệ, đặt lại thành 1
                }
                
                // Cập nhật giỏ hàng
                updateCartQuantity(cartId, this.value);
            });
        });

        // Hàm cập nhật giỏ hàng
        function updateCartQuantity(cartId, quantity) {
            const form = document.querySelector(`#quantity-${cartId}`).closest('form');
            form.submit();
        }
    });
</script>

<style>

.table {
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: none;
}

.table th, .table td {
    vertical-align: middle;
    border: none;
}

.quantity-col {
    width: 10%;
}

.total {
    font-weight: bold;
    font-size: 1.5rem;
    color: #28a745;
}

.product-link {
    color: black;
    text-decoration: none;
    max-width: 310px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: inline-block;
    
}

.product-link:hover {
    text-decoration: none;
}

/* Xóa nút tăng giảm số lượng mặc định của input number */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {   
    -webkit-appearance: none;
    margin: 0;
}

.table-dark {
    background-color: #6c757d;
    color: white;
}

.btn {
    transition: background-color 0.3s ease, color 0.3s ease;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}
    /* Hiệu ứng hover cho các nút */
    .btn:hover {
        opacity: 0.9; /* Giảm độ trong suốt khi hover */
        transform: translateY(-2px); /* Di chuyển nhẹ lên trên */
        transition: all 0.3s ease; /* Thêm hiệu ứng chuyển động */
    }


</style>

@endsection
