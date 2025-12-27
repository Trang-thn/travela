<?php

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
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/booking/{id?}', [BookingController::class, 'index']) ->name('booking');

// Payment with PayPal 
Route::post('/create-transaction', [PayPalController::class, 'createTransaction']) ->name('createTransaction'); 
Route::post('/process-transaction', [PayPalController::class, 'processTransaction']) ->name('processTransaction'); 
Route::post('/success-transaction', [PayPalController::class, 'successTransaction']) ->name('successTransaction'); 
Route::post('/cancel-transaction', [PayPalController::class, 'cancelTransaction']) ->name('cancelTransaction'); 
// Payment with Momo 
Route::post('/create-momo-payment', [BookingController::class, 'createMomoPayment']) ->name('createMomoPayment'); // Tour booked Route::get('/tour-booked', [TourBookedController::class, 'index']) ->name('tour-booked') ->middleware('checkLoginClient'); 
Route::post('/cancel-booking', [TourBookedController::class, 'cancelBooking']) ->name('cancel-booking');
Route::post('/create-booking', [BookingController::class, 'createBooking']) ->name('create-booking');
