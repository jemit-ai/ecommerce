<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


Route::post('/order',[OrderController::class,'store'])->name('order.place');
Route::get('/pay/{id}',[OrderController::class,'showPaymentForm'])->name('show.payment');
Route::get('/cancel/{id}',[OrderController::class,'showCancelForm'])->name('show.cancel');
Route::post('/pay-order',[OrderController::class,'payment'])->name('order.payment');
Route::post('/cancel-order',[OrderController::class,'cancel'])->name('order.cancel');
