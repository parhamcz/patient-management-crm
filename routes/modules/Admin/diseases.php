<?php

use App\Http\Controllers\Api\V1\Admin\DiseaseController;
use Illuminate\Support\Facades\Route;

Route::apiResource('diseases', DiseaseController::class);
Route::prefix('diseases')->name('disease.')->group(function () {
    Route::post('/excel', [DiseaseController::class, 'importExcelFile'])->name('excel');
});
