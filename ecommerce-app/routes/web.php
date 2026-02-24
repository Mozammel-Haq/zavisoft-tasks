<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
// Health check for Render — must return 200
Route::get('/health', function () {
    return response('OK', 200);
});
Route::get('/',fn()=>redirect()->route('login'));

Route::get('/login',[LoginController::class,'showForm'])->name('login');

Route::post('/login',[LoginController::class,'login'])->name('login.post');

Route::post('/logout',[LoginController::class,'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
});
