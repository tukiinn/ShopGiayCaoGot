    <?php

    use App\Http\Controllers\OrderController;
    use App\Http\Controllers\PaymentController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\CartController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\StatisticsController;

    // Admin routes 
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/categories', [AdminController::class, 'categoriesIndex'])->name('categories.index');
        Route::get('/categories/create', [AdminController::class, 'categoriesCreate'])->name('categories.create');
        Route::post('/categories', [AdminController::class, 'categoriesStore'])->name('categories.store');
        Route::get('/categories/{category}/edit', [AdminController::class, 'categoriesEdit'])->name('categories.edit');
        Route::put('/categories/{category}', [AdminController::class, 'categoriesUpdate'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminController::class, 'categoriesDestroy'])->name('categories.destroy');
        Route::get('/categories/{category}', [AdminController::class, 'categoriesShow'])->name('categories.show');
        
        Route::get('/products', [AdminController::class, 'productsIndex'])->name('products.index');
        Route::get('/products/create', [AdminController::class, 'productsCreate'])->name('products.create');
        Route::post('/products', [AdminController::class, 'productsStore'])->name('products.store');
        Route::get('/products/{product}/edit', [AdminController::class, 'productsEdit'])->name('products.edit');
        Route::put('/products/{product}', [AdminController::class, 'productsUpdate'])->name('products.update');
        Route::delete('/products/{product}', [AdminController::class, 'productsDestroy'])->name('products.destroy');
        Route::get('/products/{product}', [AdminController::class, 'productsShow'])->name('products.show');


    Route::delete('/orders/destroy-all', [OrderController::class, 'destroyAll'])->name('orders.destroyAll');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');  
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index'); // Hiển thị danh sách tất cả đơn hàng
    Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->name('orders.show'); // Hiển thị chi tiết đơn hàng cho admin
    Route::delete('/orders/{order}', [OrderController::class, 'Admdestroy'])->name('orders.destroy'); // Xóa đơn hàng
    Route::patch('/orders/{order}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus'); // Cập nhật trạng thái đơn hàng
        Route::get('/dashboard', [StatisticsController::class, 'dashboard'])->name('dashboard'); 


    });

    Route::get('/admin/revenue-data', [StatisticsController::class, 'getRevenueData']);
    Route::get('/admin/category-revenue-data', [StatisticsController::class, 'getCategoryRevenueForChart']);
    Route::get('/admin/payment-revenue-data', [StatisticsController::class, 'getPaymentMethodRevenueData']);




Route::get('customer/orders/thank-you-momo', [PaymentController::class, 'handleMomoNotify'])->name('customer.thank_you_momo');
    Route::get('customer/orders/thank-you', [PaymentController::class, 'thankYou'])->name('customer.thank_you');
    Route::get('/thank-you-vnpay', [PaymentController::class, 'thankYouVNPay'])->name('customer.thank_you_vnpay');
Route::get('/vnpay-ipn', [PaymentController::class, 'handleVNPayCallback'])->name('customer.vnpay_ipn');


Route::get('/api/addresses', [HomeController::class, 'getAddresses']);



    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login'); 
    Route::post('login', [AuthController::class, 'login']);  
    Route::post('logout', [AuthController::class, 'logout'])->name('logout'); 

    // Password reset routes
    Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

        Route::prefix('customer')->group(function () {

        // Route cho sản phẩm của khách hàng
        Route::get('/products', [ProductController::class, 'index'])->name('customer.products.index'); // Danh sách sản phẩm
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('customer.products.show'); // Chi tiết sản phẩm
        Route::get('/categories', [CategoryController::class, 'index'])->name('customer.categories.index');
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('customer.categories.show');
        Route::get('/search', [ProductController::class, 'search'])->name('customer.products.search');

        Route::get('orders', [OrderController::class, 'index'])->name('customer.orders.index'); // Hiển thị danh sách đơn hàng
        Route::get('orders/create', [OrderController::class, 'create'])->name('customer.orders.create'); // Tạo đơn hàng
        Route::post('orders', [OrderController::class, 'store'])->name('customer.orders.store'); // Lưu đơn hàng
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('customer.orders.show'); // Hiển thị chi tiết đơn hàng
        Route::patch('orders/{order}/request-cancel', [OrderController::class, 'requestCancel'])->name('customer.orders.requestCancel');
        Route::patch('orders/{order}/cancel-request', [OrderController::class, 'cancelRequest'])->name('customer.orders.cancelRequest');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('customer.orders.destroy');

        Route::get('/cart/payment', [PaymentController::class, 'showPaymentForm'])->name('customer.cart.payment.form'); // Hiển thị form thanh toán
        Route::post('/cart/payment', [PaymentController::class, 'storeFromCart'])->name('customer.cart.payment'); // Xử lý thanh toán

    Route::get('/cart', [CartController::class, 'index'])->name('customer.cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('customer.cart.add');
    Route::put('/cart/update/{cartId}', [CartController::class, 'updateCart'])->name('customer.cart.update');
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'removeFromCart'])->name('customer.cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('customer.cart.clear');
    Route::post('/cart/retry/{id}', [PaymentController::class, 'retryPayment'])->name('customer.payment.retry');


    });
    
    



