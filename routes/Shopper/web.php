<?php

use App\Http\Controllers\Shopper\ShopperQueueController;
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



Route::name('checkin')
    ->post('/sign-in/{locationUuid}/check-in', [ShopperQueueController::class, 'checkIn']);

Route::name('checkout')
    ->get('checkout/{shopperUuid}', [ShopperQueueController::class, 'checkOut']);

Route::name('check-pending')
    ->get('check-pending/{shopperUuid}', [ShopperQueueController::class, 'checkPending']);
