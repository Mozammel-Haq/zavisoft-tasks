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

Route::get('/update-client', function () {
    $foodpandaUrl = env('FOODPANDA_URL');
    $redirectUri  = $foodpandaUrl . '/auth/callback';

    \Laravel\Passport\Client::where('name', 'Foodpanda App')
        ->update(['redirect_uris' => $redirectUri]);

    $client = \Laravel\Passport\Client::where('name', 'Foodpanda App')->first();

    return response()->json([
        'message'     => 'Client updated',
        'id'          => $client->id,
        'secret'      => $client->secret,
        'redirect_uri'=> $redirectUri,
    ]);
});
