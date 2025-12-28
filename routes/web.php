<?php

use App\Http\Controllers\clients\UserProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clients\HomeController;
use App\Http\Controllers\clients\AboutController;
use App\Http\Controllers\clients\ToursController;
use App\Http\Controllers\clients\TourGuidesController;
use App\Http\Controllers\clients\DestinationController;
use App\Http\Controllers\clients\ContactController;
use App\Http\Controllers\clients\TourDetailController;
use App\Http\Controllers\clients\BlogController;
use App\Http\Controllers\clients\BlogDetailController;
use App\Http\Controllers\clients\BookingController;
use App\Http\Controllers\clients\LoginController;
use App\Http\Controllers\clients\PayPalController;
use App\Http\Controllers\clients\TourBookedController;


// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/tours', [ToursController::class, 'index'])->name('tours');
Route::get('/tour-guides', [TourGuidesController::class, 'index'])->name('tour-guides');
Route::get('/destination', [DestinationController::class, 'index'])->name('destination');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/tour-detail', [TourDetailController::class, 'index'])->name('tour-detail');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog-detail', [BlogDetailController::class, 'index'])->name('blog-detail');
//LOGIN - LOGOUT - REGISTER
Route::get('/login', [LoginController::class, 'index'])->name('login');
//Booking
Route::get('/booking/{id?}', [BookingController::class, 'index']) ->name('booking');
Route::get('/tour-booked', [TourBookedController::class,'index'])->name('tour-booked');
Route::post('/cancel-booking', [TourBookedController::class, 'cancelBooking']) ->name('cancel-booking');
Route::post('/create-booking', [BookingController::class, 'createBooking']) ->name('create-booking');
//
// Tạo giao dịch 
Route::post('/create-momo-payment', [PayPalController::class, 'createMomoPayment'])->name('createMomoPayment'); 
// Callback IPN (MoMo gọi server → server) 
Route::post('/momo-ipn', [PayPalController::class, 'momoIpn'])->name('momoIpn'); 
// Redirect sau khi thanh toán (người dùng quay lại) 
Route::get('/momo-success', [PayPalController::class, 'momoSuccess'])->name('momoSuccess'); 
Route::get('/momo-cancel', [PayPalController::class, 'momoCancel'])->name('momoCancel');

// Payment with PayPal 
Route::post('/create-transaction', [PayPalController::class, 'createTransaction']) ->name('createTransaction'); 
Route::post('/process-transaction', [PayPalController::class, 'processTransaction']) ->name('processTransaction'); 
Route::post('/success-transaction', [PayPalController::class, 'successTransaction']) ->name('successTransaction'); 
Route::post('/cancel-transaction', [PayPalController::class, 'cancelTransaction']) ->name('cancelTransaction'); 
// Payment with Momo 
//Route::post('/create-momo-payment', [PayPalController::class, 'createMomoPayment']) ->name('createMomoPayment'); // Tour booked 
//Route::get('/tour-booked', [TourBookedController::class, 'index']) ->name('tour-booked') ->middleware('checkLoginClient'); 

Route::post('/login', [LoginController::class, 'login'])->name('user-login');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/activate-account/{token}', [LoginController::class, 'activateAccount'])->name('activate.account');
//USER PROFILE
Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user-profile');
Route::post('/user-profile', [UserProfileController::class, 'update'])->name('update-user-profile');
Route::post('/change-password-profile', [UserProfileController::class, 'changePassword'])->name('change-password');
// >>>>>>> e573aac15b9eb28ae49b90d7638665ec7fa9e1ba
