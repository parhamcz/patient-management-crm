<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\LoginController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('login', [LoginController::class, 'login'])
        ->name('login');
    Route::get('logout', [LoginController::class, 'logout'])
        ->name('logout')->middleware('auth:api');
});
