<?php

use App\Http\Controllers\Api\V1\Admin\FileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('files', FileController::class);
Route::prefix('files')->name('file.')->group(function () {
    Route::prefix('upload')->name('upload.')->group(function () {
        Route::post('medical-history/{file}', [FileController::class, 'uploadMedicalHistory'])
            ->name('medical-history');
        Route::post('before-operation/{file}', [FileController::class, 'uploadBeforeOperation'])
            ->name('before-operation');
        Route::post('during-operation/{file}', [FileController::class, 'uploadDuringOperation'])
            ->name('during-operation');
        Route::post('after-operation/{file}', [FileController::class, 'uploadAfterOperation'])
            ->name('after-operation');
        Route::post('disease-comparison/{file}', [FileController::class, 'uploadDiseaseComparison'])
            ->name('disease-comparison');
    });
});
