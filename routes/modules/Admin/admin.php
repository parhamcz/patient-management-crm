<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth:api', 'isAdmin'])->group(function () {
    require_once __DIR__ . '/congresses.php';
    require_once __DIR__ . '/diseases.php';
    require_once __DIR__ . '/files.php';
    require_once __DIR__ . '/patients.php';
    require_once __DIR__ . '/hospitals.php';
    require_once __DIR__ . '/users.php';
});
