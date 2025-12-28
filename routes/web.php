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
use App\Http\Controllers\clients\LoginController;


// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/tours', action: [ToursController::class, 'index'])->name('tours');
Route::get('/tour-guides', [TourGuidesController::class, 'index'])->name('tour-guides');
Route::get('/destination', [DestinationController::class, 'index'])->name('destination');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/tour-detail', [TourDetailController::class, 'index'])->name('tour-detail');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog-detail', [BlogDetailController::class, 'index'])->name('blog-detail');
//LOGIN - LOGOUT - REGISTER
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('user-login');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/activate-account/{token}', [LoginController::class, 'activateAccount'])->name('activate.account');
//USER PROFILE
Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user-profile');
Route::post('/user-profile', [UserProfileController::class, 'update'])->name('update-user-profile');
Route::post('/change-password-profile', [UserProfileController::class, 'changePassword'])->name('change-password');
