<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Payment; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
     // Hàm tính toán thống kê hiển thị trên dashboard
     public function dashboard()
     {
         // Tổng số đơn hàng
         $totalOrders = Order::count();
     
         // Tổng số khách hàng riêng biệt
         $totalCustomers = User::whereHas('orders')->count();
     
         // Tổng số đơn hàng chưa hoàn thành
         $totalPendingOrders = Order::whereIn('status', ['pending', 'paid', 'confirmed'])->count();
     
         // Tổng số đơn hàng đã hoàn thành
         $totalCompletedOrders = Order::where('status', 'completed')->count();
     
         // Tổng số đơn hàng đã hủy
         $totalCancelledOrders = Order::where('status', 'cancelled')->count();
     
         // Doanh thu theo danh mục cho đơn hàng đã hoàn thành
         $revenueByCategoryCompleted = $this->getCategoryRevenueForChart();
     
         // Tổng doanh thu cho đơn hàng đã hoàn thành
         $totalRevenueCompleted = Payment::whereIn('order_id', Order::where('status', 'completed')->pluck('id'))->sum('price');
     
         // Tổng doanh thu cho đơn hàng chưa hoàn thành
         $totalRevenuePending = Payment::whereIn('order_id', Order::whereIn('status', ['pending', 'paid', 'confirmed'])->pluck('id'))->sum('price');
     
         // Doanh thu theo ngày cho đơn hàng đã hoàn thành
         $revenueByDayCompleted = Payment::select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(price) as revenue'))
             ->whereIn('order_id', Order::where('status', 'completed')->pluck('id')) // Chỉ tính đơn hàng đã hoàn thành
             ->groupBy(DB::raw('DATE(created_at)'))
             ->get();
     
         // Doanh thu theo tháng cho đơn hàng đã hoàn thành
         $revenueByMonthCompleted = Payment::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(price) as revenue'))
             ->whereIn('order_id', Order::where('status', 'completed')->pluck('id')) // Chỉ tính đơn hàng đã hoàn thành
             ->groupBy(DB::raw('MONTH(created_at)'))
             ->get();
     
         // Doanh thu theo năm cho đơn hàng đã hoàn thành
         $revenueByYearCompleted = Payment::select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(price) as revenue'))
             ->whereIn('order_id', Order::where('status', 'completed')->pluck('id')) // Chỉ tính đơn hàng đã hoàn thành
             ->groupBy(DB::raw('YEAR(created_at)'))
             ->get();
     
         // Lấy danh sách danh mục
         $categories = Category::all();
     
         return view('admin.dashboard', compact(
             'totalOrders',
             'totalCustomers',
             'totalPendingOrders',
             'totalCompletedOrders',  
             'totalCancelledOrders',  
             'revenueByCategoryCompleted',
             'revenueByDayCompleted',
             'revenueByMonthCompleted',
             'revenueByYearCompleted',
             'totalRevenueCompleted',
             'totalRevenuePending',
             'categories'
         ));
     }
     

    // Hàm lấy dữ liệu doanh thu theo thời gian và danh mục (cho biểu đồ AJAX)
    public function getRevenueData(Request $request)
    {
        $timeframe = $request->query('timeframe', 'day');
    
        $data = $this->getRevenueByTimeframe($timeframe);
    
        return response()->json([
            'completed' => $data['completed'],
            'pending' => $data['pending'],
        ]);
    }
    
    private function getRevenueByTimeframe($timeframe)
    {
        switch ($timeframe) {
            case 'day':
                return [
                    'completed' => Payment::selectRaw('DATE(created_at) as label, SUM(price) as revenue')
                        ->whereHas('order', function ($query) {
                            $query->where('status', 'completed');
                        })
                        ->groupBy('label')
                        ->get(),
                    'pending' => Payment::selectRaw('DATE(created_at) as label, SUM(price) as revenue')
                        ->whereHas('order', function ($query) {
                            $query->whereIn('status', ['pending', 'paid', 'confirmed']);
                        })
                        ->groupBy('label')
                        ->get(),
                ];
            case 'month':
                return [
                    'completed' => Payment::selectRaw('MONTH(created_at) as label, SUM(price) as revenue')
                        ->whereHas('order', function ($query) {
                            $query->where('status', 'completed');
                        })
                        ->groupBy('label')
                        ->get(),
                    'pending' => Payment::selectRaw('MONTH(created_at) as label, SUM(price) as revenue')
                        ->whereHas('order', function ($query) {
                            $query->whereIn('status', ['pending', 'paid', 'confirmed']);
                        })
                        ->groupBy('label')
                        ->get(),
                ];
            case 'year':
                return [
                    'completed' => Payment::selectRaw('YEAR(created_at) as label, SUM(price) as revenue')
                        ->whereHas('order', function ($query) {
                            $query->where('status', 'completed');
                        })
                        ->groupBy('label')
                        ->get(),
                    'pending' => Payment::selectRaw('YEAR(created_at) as label, SUM(price) as revenue')
                        ->whereHas('order', function ($query) {
                            $query->whereIn('status', ['pending', 'paid', 'confirmed']);
                        })
                        ->groupBy('label')
                        ->get(),
                ];
            default:
                return [];
        }
    }
    
    


    public function getCategoryRevenueForChart()
    {
        return Product::join('order_product', 'products.id', '=', 'order_product.product_id')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.status', 'completed') // Chỉ lấy đơn hàng hoàn thành
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(products.price * order_product.quantity) as revenue') // Tính doanh thu từ giá sản phẩm nhân với số lượng
            )
            ->groupBy('categories.name')
            ->get();
    }
    

    public function getPaymentMethodRevenueData()
    {
        $paymentData = Order::select('payment_method', DB::raw('SUM(total_price) as revenue'))
                            ->where('status', 'completed')  
                            ->groupBy('payment_method')
                            ->get();
    
        return response()->json($paymentData);
    }
    


}
