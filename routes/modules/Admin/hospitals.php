<?php

use App\Http\Controllers\Api\V1\Admin\HospitalController;
use Illuminate\Support\Facades\Route;

Route::apiResource('hospitals', HospitalController::class);
Route::prefix('hospitals')->name('hospital.')->group(function () {
});
