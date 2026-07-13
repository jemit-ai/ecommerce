<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductImportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrderController;

Route::middleware('guest')->group(function () {
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);


    Route::post('/order',[OrderController::class,'store'])->name('order.place');

    Route::get('/pay',[OrderController::class,'showPaymentForm'])->name('show.payment');
    Route::post('/pay-order',[OrderController::class,'payment'])->name('order.payment');
    Route::post('/cancel-order',[OrderController::class,'cancel'])->name('order.cancel');
    
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/import', [ProductImportController::class, 'index'])->name('products.import');
    Route::post('/import', [ProductImportController::class, 'import'])->name('products.import.post');

    Route::get('/notifications/unread', function () {

        $notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->get();

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications,
        ]);
    });

});


