<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng của người dùng
    public function index()
    {
        // Sử dụng paginate để phân trang, hiển thị 10 đơn hàng trên mỗi trang
        $orders = Order::where('user_id', Auth::id())->paginate(8);
        
        return view('customer.orders.index', compact('orders'));
    }
    


    // Hiển thị chi tiết đơn hàng
    public function show(Order $order)
    {
        // Kiểm tra quyền truy cập
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.orders.show', compact('order'));
    }

    // Hiển thị danh sách tất cả đơn hàng cho admin
    public function adminIndex(Request $request)
    {
        $query = Order::query();
    
        // Lọc theo phương thức thanh toán
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
    
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        // Sắp xếp theo ngày
        if ($request->filled('sort_by_date')) {
            if ($request->sort_by_date === 'asc') {
                $query->orderBy('created_at', 'asc'); // Từ sớm nhất
            } elseif ($request->sort_by_date === 'desc') {
                $query->orderBy('created_at', 'desc'); // Từ muộn nhất
            }
        }
    
        // Phân trang và giữ lại các tham số lọc
        $orders = $query->with('customer')->paginate(10)->appends($request->except('page'));
    
        return view('admin.orders.index', compact('orders'));
    }
    
    
    

    // Hiển thị chi tiết đơn hàng cho admin
    public function adminShow(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    // Xóa đơn hàng
    public function Admdestroy(Order $order)
    {
        // Kiểm tra quyền truy cập cho admin
        // Thực hiện xóa đơn hàng
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xóa thành công!');
    }
    public function updateStatus(Request $request, Order $order)
    {
        // Xác thực dữ liệu
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,paid,cancelled',
        ]);
    
        $oldStatus = $order->status; // Lưu trạng thái cũ của đơn hàng
        $newStatus = $request->status; // Trạng thái mới
    
        // Cập nhật trạng thái
        $order->update(['status' => $newStatus]);
    
        // Nếu trạng thái cũ không phải là "hủy" và trạng thái mới là "hủy", trả lại số lượng sản phẩm
        if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
            $orderedProducts = DB::table('order_product')->where('order_id', $order->id)->get(); // Lấy dữ liệu từ bảng order_product
    
            foreach ($orderedProducts as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity += $item->quantity; // Tăng số lượng sản phẩm trong kho
                    $product->save();
                }
            }
        }
    
        // Chuyển hướng lại với thông báo thành công
        return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
    }
    

    public function requestCancel(Order $order)
    {
        // Kiểm tra xem đơn hàng có thể được hủy ngay lập tức
        if ($order->status === 'pending') {
            $order->status = 'cancelled'; // Đổi trạng thái đơn hàng thành đã hủy
            $order->request_cancel = false; // Đánh dấu không còn yêu cầu hủy
            $order->save();
    
            // Trả lại số lượng sản phẩm vào kho
            $orderedProducts = DB::table('order_product')->where('order_id', $order->id)->get();
            foreach ($orderedProducts as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity += $item->quantity; // Tăng số lượng sản phẩm trong kho
                    $product->save();
                }
            }
    
            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
        }
    
        // Nếu đơn hàng đã được xác nhận
        if ($order->status === 'confirmed') {
            $order->request_cancel = true; // Đánh dấu yêu cầu hủy
            $order->save();
    
            return redirect()->back()->with('success', 'Yêu cầu hủy đơn hàng đã được gửi, vui lòng chờ xác nhận.');
        }
    
        // Trường hợp đơn hàng không thể hủy
        return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
    }
    


    public function cancel(Order $order)
    {
        // Xác nhận hủy đơn hàng
        if ($order->request_cancel) {
            $order->status = 'cancelled'; // Đặt trạng thái là đã hủy
            $order->request_cancel = false; // Đánh dấu yêu cầu hủy đã xử lý
            $order->save();
    
            // Trả lại số lượng sản phẩm vào kho
            $orderedProducts = DB::table('order_product')->where('order_id', $order->id)->get();
            foreach ($orderedProducts as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->quantity += $item->quantity; // Tăng số lượng sản phẩm trong kho
                    $product->save();
                }
            }
    
            return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được hủy thành công.');
        }
    
        return redirect()->route('admin.orders.index')->with('error', 'Không thể hủy đơn hàng này.');
    }
    
    
    public function cancelRequest($id)
    {
        $order = Order::findOrFail($id);
    
        if (!$order->request_cancel) {
            return redirect()->back()->with('message', 'Chưa có yêu cầu hủy để hủy.');
        }
    
        // Cập nhật lại trạng thái yêu cầu hủy
        $order->request_cancel = false;
        $order->save();
    
        // Thêm thông báo thành công
        return redirect()->back()->with('success', 'Yêu cầu hủy đơn hàng đã được hủy thành công.');
    }
public function destroy(Order $order)
{
    // Xóa đơn hàng
    $order->delete();

    return redirect()->route('customer.orders.index')->with('success', 'Đơn hàng đã được xóa thành công.');
}
public function destroyAll()
{
    // Lấy tất cả các đơn hàng
    $orders = Order::all();
    
    // Xóa từng đơn hàng
    foreach ($orders as $order) {
        $order->delete();
    }

    return redirect()->route('admin.orders.index')->with('success', 'Tất cả đơn hàng đã được xóa thành công!');
}

}
