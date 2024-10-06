<?php

use App\Http\Controllers\Api\V1\Doctor\PatientController;
use Illuminate\Support\Facades\Route;

Route::apiResource('patients', PatientController::class);
Route::prefix('patients')->name('patient.')->group(function () {
    Route::prefix('upload')->name('upload.')->group(function () {
        Route::post('/avatar/{patient}', [PatientController::class, 'uploadAvatar'])->name('avatar');
        Route::post('/excel', [PatientController::class, 'importExcelFile'])->name('excel');
    });
});
