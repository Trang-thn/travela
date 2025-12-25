<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clients\HomeController;
use App\Http\Controllers\clients\AboutController;
use App\Http\Controllers\clients\ServiceController;

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/service', [AboutController::class, 'index'])->name('service');