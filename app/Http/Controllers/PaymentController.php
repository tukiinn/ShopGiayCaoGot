<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class PaymentController extends Controller
{
    public function storeFromCart(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string|in:cod,momo,momo_qr', // Thêm momo_qr vào danh sách phương thức thanh toán
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^(0|\+84)[0-9]{9}$/'],
            'price' => 'required|integer|min:1',
        ], [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại hợp lệ (ví dụ: 0123456789 hoặc +840123456789).',
        ]);
    
        // Tạo một đơn hàng mới
        $order = Order::create([
            'user_id' => Auth::id(),    
            'name' => $validated['name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'payment_method' => $validated['payment_method'],
            'total_price' => $validated['price'],
            'status' => $validated['payment_method'] === 'momo'  ? 'pending' : 'pending',
        ]);
    
        // Nếu phương thức thanh toán là MoMo
        if ($validated['payment_method'] === 'momo') {
            // Tạo bản ghi thanh toán cho MoMo
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->payment_method = 'momo';
            $payment->price = $validated['price'];
            $payment->save();
    
            return $this->createMomoTransaction($order);
        }
    
        // Nếu phương thức thanh toán là MoMo QR
        if ($validated['payment_method'] === 'momo_qr') {
            // Tạo bản ghi thanh toán cho MoMo QR
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->payment_method = 'momo_qr';
            $payment->price = $validated['price'];
            $payment->save();
    
            return $this->createMomoQrTransaction($order); // Gọi hàm xử lý MoMo QR
        }
    

    
        // Tạo bản ghi thanh toán cho COD
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->payment_method = 'cod';
        $payment->price = $validated['price']; 
        $payment->save();
    
        // Gán sản phẩm từ giỏ hàng vào đơn hàng
        $this->attachProductsToOrder($order);
    
        // Xóa giỏ hàng sau khi thanh toán
        $this->clearCart();
    
        return redirect()->route('customer.thank_you')->with('success', 'Đặt hàng thành công!');
    }
    
    
    public function thankYou(Request $request)
    {
        return view('customer.thank_you');
    }
    

    // Tạo giao dịch MoMo
    private function createMomoTransaction(Order $order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $order->total_price; // Lấy giá trị thanh toán từ đơn hàng
        $orderId =  $orderId = $this->generateNewOrderId($order);// Mã đơn hàng
        $redirectUrl = route('customer.thank_you_momo');
        $ipnUrl = route('customer.thank_you_momo');
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // Chuẩn bị dữ liệu gửi đi
        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        // Gửi yêu cầu qua POST bằng CURL
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        Log::info('MoMo Payment Response: ', ['response' => $result]);


          // Gán sản phẩm từ giỏ hàng vào đơn hàng
          $this->attachProductsToOrder($order);
          // Xóa giỏ hàng sau khi thanh toán
          $this->clearCart(); // Giả sử phương thức này xóa giỏ hàng
        // Kiểm tra và điều hướng đến URL thanh toán của MoMo
        if (isset($jsonResult['payUrl'])) {
            return redirect($jsonResult['payUrl']); // Chuyển hướng người dùng đến URL thanh toán
        }

        return redirect()->route('customer.orders.index')->with('error', 'Đã xảy ra lỗi trong quá trình thanh toán với MoMo.');
    }

    // Hàm sử dụng CURL để gửi request tới MoMo
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Tăng thời gian chờ nếu cần
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Tăng thời gian kết nối nếu cần
    
        $result = curl_exec($ch);
    
        // Xử lý lỗi cURL
        if (curl_errno($ch)) {
            $errorMessage = curl_error($ch);
            // Ghi log hoặc xử lý thông báo lỗi
            Log::error("cURL Error: " . $errorMessage);
            return json_encode(['error' => 'Đã xảy ra lỗi khi kết nối đến dịch vụ thanh toán.']);
        }
    
        curl_close($ch);
        return $result;
    }
    

    // Gán sản phẩm từ giỏ hàng vào đơn hàng
    protected function attachProductsToOrder(Order $order)
    {
        $carts = Cart::where('user_id', Auth::id())->get();

        foreach ($carts as $cart) {
            // Gán sản phẩm vào đơn hàng
            $order->products()->attach($cart->product_id, ['quantity' => $cart->quantity]);

            // Cập nhật số lượng sản phẩm trong kho
            $product = $cart->product;
            $product->quantity -= $cart->quantity; // Trừ số lượng sản phẩm trong kho
            $product->save();
        }
    }

    // Hiển thị form thanh toán
    public function showPaymentForm(Request $request)
    {
        // Lấy tất cả các sản phẩm trong giỏ hàng của người dùng
        $carts = Cart::where('user_id', Auth::id())->get();
    
        // Tính tổng giá của tất cả các sản phẩm trong giỏ hàng
        $total_price = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });
    
        // Trả về view thanh toán với tất cả sản phẩm trong giỏ hàng và tổng giá
        return view('customer.orders.payment', compact('carts', 'total_price'));
    }
  
    // Phương thức để xóa giỏ hàng
    protected function clearCart()
    {
        $userId = Auth::id();
        if ($userId) {
            Cart::where('user_id', $userId)->delete();
        }
    }
    public function handleMomoNotify(Request $request)
    {
        // Ghi log thông tin nhận được
    
        // Kiểm tra kết quả giao dịch
        $resultCode = $request->input('resultCode'); // Lấy mã kết quả từ request
        $orderId = $request->input('orderId'); // Lấy ID đơn hàng từ request
    

        // Kiểm tra nếu giao dịch thành công
        if ($resultCode === '0') {
            // Cập nhật trạng thái đơn hàng
            $order = Order::find($orderId); // Tìm đơn hàng theo ID
            if ($order) {
                $order->status = 'paid'; // Cập nhật trạng thái
                $order->save(); // Lưu thay đổi
            }
            
            // Trả về view cảm ơn
            return view('customer.thank_you_momo')->with('success', 'Thanh toán thành công!');
        }
      // Tạo thông báo lỗi chi tiết từ thông tin trả về
      $message = $request->input('message', 'Không có thông tin cụ thể về lỗi.');

      // Trả về thông báo lỗi cho người dùng
      return redirect()->route('customer.orders.index')->with('error', 'Thanh toán không thành công: ' . $message);
    }
    
    public function retryPayment($id)
{
    $order = Order::find($id);

    if (!$order || $order->status !== 'pending') {
        return redirect()->route('customer.orders.index')->with('error', 'Đơn hàng không hợp lệ hoặc đã thanh toán.');
    }
    $newOrderId = $this->generateNewOrderId($order); // Tạo orderId mới

    // Xử lý theo từng phương thức thanh toán
    if ($order->payment_method === 'momo') {
        return $this->createMomoTransaction($order);
    } elseif ($order->payment_method === 'momo_qr') {
        return $this->createMomoQrTransaction($order); // Thêm xử lý cho MoMo QR
    }

    return redirect()->route('customer.orders.index')->with('error', 'Phương thức thanh toán không được hỗ trợ.');
}


// Hàm tạo orderId mới
private function generateNewOrderId(Order $order)
{
    return $order->id . '-' . time(); // Tạo orderId mới bằng cách thêm thời gian vào orderId cũ
}
private function createMomoQrTransaction(Order $order)
{
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    $orderInfo = "Thanh toán qua MoMo QR";
    $amount = $order->total_price; // Lấy giá trị thanh toán từ đơn hàng
    $orderId = $this->generateNewOrderId($order); // Mã đơn hàng
    $redirectUrl = route('customer.thank_you_momo');
    $ipnUrl = route('customer.thank_you_momo');
    $extraData = "";

    $requestId = time() . "";
    $requestType = "captureWallet"; // Thay đổi loại yêu cầu
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);

    // Chuẩn bị dữ liệu gửi đi
    $data = [
        'partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature
    ];

    // Gửi yêu cầu qua POST bằng CURL
    $result = $this->execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);
    Log::info('MoMo QR Payment Response: ', ['response' => $result]);

    // Gán sản phẩm từ giỏ hàng vào đơn hàng
    $this->attachProductsToOrder($order);
    // Xóa giỏ hàng sau khi thanh toán
    $this->clearCart(); // Giả sử phương thức này xóa giỏ hàng
    // Kiểm tra và điều hướng đến URL thanh toán của MoMo
    if (isset($jsonResult['payUrl'])) {
        return redirect($jsonResult['payUrl']); // Chuyển hướng người dùng đến URL thanh toán
    }

    return redirect()->route('customer.orders.index')->with('error', 'Đã xảy ra lỗi trong quá trình thanh toán với MoMo QR.');
}

}
