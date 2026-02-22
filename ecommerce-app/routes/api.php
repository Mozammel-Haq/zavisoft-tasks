<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function(){
    Route::get('/user',[UserController::class,'authUser']);
});
