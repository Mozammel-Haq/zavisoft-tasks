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
    // Determine the environment and redirect URI
    $foodpandaUrl = env('FOODPANDA_URL', 'https://zavi-foodpanda.up.railway.app');
    $redirectUri  = $foodpandaUrl . '/auth/callback';

    // Find the client by ID or name
    $client = \Laravel\Passport\Client::where('id', '019c90c1-32cf-732d-877b-b8b3836cd218')
                ->orWhere('name', 'Foodpanda App')
                ->first();
    
    if (!$client) {
        return response()->json(['error' => 'Client not found. Make sure the seeder was run.'], 404);
    }

    // Force valid JSON arrays for the columns that Passport now expects to be arrays
    // Using the model's update() method will trigger casts if they are defined,
    // but just to be safe, we ensure arrays are passed as expected by newer Passport.
    $client->update([
        'redirect_uris' => [$redirectUri],
        'grant_types'   => ['authorization_code', 'refresh_token', 'personal_access'],
        'revoked'       => false,
    ]);

    return response()->json([
        'message'      => 'Foodpanda OAuth client repaired and updated successfully.',
        'client_id'    => $client->id,
        'redirect_uri' => $redirectUri,
        'state'        => [
            'redirect_uris' => $client->redirect_uris,
            'grant_types'   => $client->grant_types,
        ]
    ]);
});
