<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', UserController::class);
//    Route::get('users', [UserController::class, 'index'])->name('users.index');
//    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::resource('rooms', RoomController::class);
    Route::get('rooms-booking', [RoomController::class, 'roomsBooking'])->name('rooms.booking-to-client');
    Route::post('rooms-booking', [RoomController::class, 'roomBookingAction'])->name('rooms.room-booking-action');
    Route::get('booking/user', [BookingController::class, 'roomsBookingToClint'])->name('booking.rooms-clint');

    Route::resource('bookings', BookingController::class);
});