<?php

use App\Http\Controllers\Api\V1\Admin\CongressController;
use Illuminate\Support\Facades\Route;

Route::apiResource('congresses', CongressController::class);
Route::prefix('congresses')->name('congress.')->group(function () {
});
