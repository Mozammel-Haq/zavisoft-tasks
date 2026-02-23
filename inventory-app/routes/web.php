<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

// Public

Route::get('/',fn()=>redirect()->route('login'));

Route::get('/login',[LoginController::class,'showForm'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('login.post');
Route::post('/logout',[LoginController::class,'logout'])->middleware('auth')->name('logout');


// Private

Route::middleware('auth')->group(function(){
    // Dashboard
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    // Products $ Sales
    Route::resource('products',ProductController::class)->only(['index','create','store','show','edit','update']);
    Route::resource('sales',SaleController::class)->only(['index','create','store','show']);

    // Journal
    Route::get('/journal',       [JournalController::class, 'index'])->name('journal.index');
    Route::get('/journal/{journalEntry}', [JournalController::class, 'show'])->name('journal.show');

    // Reports
    Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
});
