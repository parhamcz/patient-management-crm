<?php

use App\Http\Controllers\Api\V1\Admin\HospitalController;
use Illuminate\Support\Facades\Route;

Route::apiResource('hospitals', HospitalController::class)->only(['index', 'show']);
Route::prefix('hospitals')->name('hospital.')->group(function () {
});
