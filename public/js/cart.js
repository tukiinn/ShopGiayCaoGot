document.getElementById('clear-cart-btn').addEventListener('click', function() {
    if (confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng không?')) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = "/customer/cart/clear"; // Đường dẫn cụ thể
        form.innerHTML = '{{ csrf_field() }}' + 
                         '<input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
});
