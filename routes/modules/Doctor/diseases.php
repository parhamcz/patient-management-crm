<?php

use App\Http\Controllers\Api\V1\Doctor\DiseaseController;
use Illuminate\Support\Facades\Route;

Route::apiResource('diseases', DiseaseController::class);
Route::prefix('diseases')->name('disease.')->group(function () {
});
