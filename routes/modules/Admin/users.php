<?php

use App\Http\Controllers\Api\V1\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::prefix('users')->name('user.')->group(function () {
    Route::prefix('upload')->name('upload.')->group(function () {
        Route::post('/avatar/{user}', [UserController::class, 'uploadAvatar'])->name('avatar');
    });
});
