<?php

use App\Http\Controllers\Api\V1\Admin\CongressController;
use Illuminate\Support\Facades\Route;

Route::apiResource('congresses', CongressController::class)->only(['index', 'show']);
Route::prefix('congresses')->name('congresses.')->group(function () {
});
