<?php

use App\Http\Controllers\Dashboard\AskRequestController;
use App\Http\Controllers\Dashboard\BidRequestController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\UserNotificationController;
use App\Http\Controllers\Dashboard\OrderRequestController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth.dashboard']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('users', [UserController::class, 'index'])->name('dashboard.users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('dashboard.users.create');
    Route::post('users', [UserController::class, 'store'])->name('dashboard.users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('dashboard.users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('dashboard.users.edit');
    Route::patch('users/{user}', [UserController::class, 'update'])->name('dashboard.users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('dashboard.users.destroy');

    Route::post('users/{user}/reset-password', [UserNotificationController::class, 'sendResetPassword'])->name('dashboard.users.reset.password');
    Route::post('users/{user}/reset-pin', [UserNotificationController::class, 'sendResetPin'])->name('dashboard.users.reset.pin');

    Route::get('transactions', [TransactionController::class, 'index'])->name('dashboard.transactions.index');
    Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('dashboard.transactions.show');

    Route::get('orders', [OrderRequestController::class, 'index'])->name('dashboard.order_request.index');
    Route::get('orders/create', [OrderRequestController::class, 'create'])->name('dashboard.order_request.create');
    Route::post('orders/create', [OrderRequestController::class, 'store'])->name('dashboard.order_request.store');

    Route::get('orders/{order}/edit', [OrderRequestController::class, 'edit'])->name('dashboard.order_request.edit');
    // Route::get('orders/{order}', [OrderRequestController::class, 'show'])->name('dashboard.users.show');
    Route::patch('orders/{order}', [OrderRequestController::class, 'update'])->name('dashboard.order_request.update');

    Route::delete('orders/{order}', [OrderRequestController::class, 'destroy'])->name('dashboard.order_request.destroy');

    Route::get('orders/{id}', [OrderRequestController::class, 'show'])->name('dashboard.order_request.show');


 
    Route::get('settings/profile', [\App\Http\Controllers\Dashboard\SettingsController::class, 'profile'])->name('dashboard.settings.profile');
    Route::post('settings/profile', [\App\Http\Controllers\Dashboard\SettingsController::class, 'updateProfile'])->name('dashboard.settings.profile.update');
    Route::post('settings/password', [\App\Http\Controllers\Dashboard\SettingsController::class, 'updatePassword'])->name('dashboard.settings.password.update');

    Route::post('logout',           [DashboardController::class, 'logout'])->name('dashboard.logout');
});

Route::group(['middleware' => 'guest.dashboard'], function()
{
    Route::get('login',     [DashboardController::class, 'login'])->name('dashboard.login');
    Route::post('login',    [DashboardController::class, 'store']);
});
