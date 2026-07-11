<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductImportController;
use App\Http\Controllers\Auth\LoginController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
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

    Route::post('order',[OrderController::class,'store'])->name('order.place');
        
});


