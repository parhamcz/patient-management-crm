<?php

use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('profile', [UserController::class, 'profile'])->middleware('auth:api')->name('profile');
Route::get('search', [SearchController::class, 'search'])->middleware('auth:api')->name('search');
require_once __DIR__ . "/modules/Auth/auth.php";
require_once __DIR__ . "/modules/Admin/admin.php";
require_once __DIR__ . "/modules/Doctor/user.php";
