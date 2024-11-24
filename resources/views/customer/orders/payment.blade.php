@extends('layouts.customer')

@section('content')

<div class="container my-5">
    <title>Đặt hàng</title>
    <h2 class="text-center mb-4">Đặt hàng</h2>

    <form action="{{ route('customer.cart.payment') }}" method="POST">
        @csrf

        <!-- Họ và Tên cùng Số Điện Thoại trên 1 dòng -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Họ và Tên</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Số Điện Thoại</label>
                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Phần địa chỉ -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="province" class="form-label">Tỉnh/Thành Phố</label>
                <select id="province" class="form-select" required>
                    <option value="">Chọn Tỉnh/Thành</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="district" class="form-label">Quận/Huyện</label>
                <select id="district" class="form-select" required disabled>
                    <option value="">Chọn Quận/Huyện</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="ward" class="form-label">Phường/Xã</label>
                <select id="ward" class="form-select" required disabled>
                    <option value="">Chọn Phường/Xã</option>
                </select>
            </div>
        </div>

        <!-- Địa chỉ chi tiết -->
        <div class="mb-3">
            <label for="detailed_address" class="form-label">Địa Chỉ Chi Tiết</label>
            <input type="text" name="detailed_address" id="detailed_address" class="form-control @error('detailed_address') is-invalid @enderror" placeholder="Số nhà, đường,..." required>
            @error('detailed_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Input địa chỉ đã hợp nhất -->
        <input type="hidden" name="address" id="address" class="form-control" required>

        <div class="mb-3">
    <label for="payment_method" class="form-label">Phương Thức Thanh Toán</label>
    <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
        <option value="cod">Thanh Toán Khi Nhận Hàng (COD)</option>
        <option value="momo">Thanh Toán Qua MoMo</option>
        <option value="momo_qr">Thanh Toán Qua MoMo QR</option> <!-- Thêm tùy chọn MoMo QR -->
    </select>
    @error('payment_method')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


        <input type="hidden" name="price" value="{{ $carts->sum(function($cart) { return $cart->product->price * $cart->quantity; }) }}">
        <h3 class="text-end text-danger">Tổng Cộng: {{ number_format($carts->sum(function($cart) { return $cart->product->price * $cart->quantity; }), 0, '.', ',') }} đ</h3>
        <button type="submit" id="buttonPayment" class="btn btn-success">Đặt hàng</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gọi API lấy danh sách tỉnh/thành phố
        fetch('https://provinces.open-api.vn/api/?depth=1')
            .then(response => response.json())
            .then(data => {
                let provinceSelect = document.getElementById('province');
                data.forEach(province => {
                    let option = document.createElement('option');
                    option.value = province.code;
                    option.text = province.name;
                    provinceSelect.add(option);
                });
            });

        // Khi chọn tỉnh/thành phố
        document.getElementById('province').addEventListener('change', function () {
            let provinceCode = this.value;
            if (provinceCode) {
                // Gọi API lấy danh sách quận/huyện
                fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
                    .then(response => response.json())
                    .then(data => {
                        let districtSelect = document.getElementById('district');
                        districtSelect.disabled = false;
                        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>'; // Xóa các tùy chọn trước đó
                        data.districts.forEach(district => {
                            let option = document.createElement('option');
                            option.value = district.code;
                            option.text = district.name;
                            districtSelect.add(option);
                        });
                    });
            }
        });

        // Khi chọn quận/huyện
        document.getElementById('district').addEventListener('change', function () {
            let districtCode = this.value;
            if (districtCode) {
                // Gọi API lấy danh sách phường/xã
                fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                    .then(response => response.json())
                    .then(data => {
                        let wardSelect = document.getElementById('ward');
                        wardSelect.disabled = false;
                        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>'; // Xóa các tùy chọn trước đó
                        data.wards.forEach(ward => {
                            let option = document.createElement('option');
                            option.value = ward.name; // Bạn có thể thay đổi nếu cần
                            option.text = ward.name;
                            wardSelect.add(option);
                        });
                    });
            }
        });

        // Khi chọn phường/xã
        document.getElementById('ward').addEventListener('change', function () {
            let province = document.getElementById('province').selectedOptions[0].text;
            let district = document.getElementById('district').selectedOptions[0].text;
            let ward = this.value;
            let detailedAddress = document.getElementById('detailed_address').value;

            // Hợp nhất địa chỉ thành một chuỗi
            let fullAddress = `${detailedAddress}, ${ward}, ${district}, ${province}`;
            document.getElementById('address').value = fullAddress;
        });

        // Theo dõi khi người dùng nhập địa chỉ chi tiết
        document.getElementById('detailed_address').addEventListener('input', function () {
            let province = document.getElementById('province').selectedOptions[0].text;
            let district = document.getElementById('district').selectedOptions[0].text;
            let ward = document.getElementById('ward').value;
            let detailedAddress = this.value;

            if (province && district && ward) {
                let fullAddress = `${detailedAddress}, ${ward}, ${district}, ${province}`;
                document.getElementById('address').value = fullAddress;
            }
        });
    });
</script>

@endsection
