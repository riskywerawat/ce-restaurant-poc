<?php

use App\Http\Controllers\AskRequestController;
use App\Http\Controllers\BidRequestController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserResetPinController;
use App\Http\Controllers\UserSetupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['auth.dashboard']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

});

Route::group([], function () {
    Route::get('/setup/{token}', [UserSetupController::class, 'create'])->name('users.setup');
    Route::post('/setup/{token}', [UserSetupController::class, 'store'])->name('users.setup.store');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboarddd', function () {
    return view('dashboard');
})->name('dashboard');
