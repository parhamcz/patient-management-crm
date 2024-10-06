<?php

use App\Http\Controllers\Api\V1\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class)->only('index');
Route::prefix('users')->name('patient.')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('index');
});
