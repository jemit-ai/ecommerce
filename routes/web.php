<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductImportController;

Route::get('/import', [ProductImportController::class, 'index'])->name('products.import');
Route::post('/import', [ProductImportController::class, 'import'])->name('products.import.post');

Route::get('/')