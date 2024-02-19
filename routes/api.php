<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SpecialtyController;
use App\Http\Controllers\Api\VoteController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\ReviewController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ProfileController::class)->group(function () {
    Route::get('doctors', 'index');
    Route::get('doctors/{slug}', 'show');
});

Route::controller(SpecialtyController::class)->group(function () {
    Route::get('specialties', 'index');
});

Route::controller(VoteController::class)->group(function () {
    Route::get('votes', 'index');
    Route::post('votes/store', 'store');
});

Route::controller(LeadController::class)->group(function () {
    Route::post('leads', 'store');
});

Route::controller(ReviewController::class)->group(function () {
    Route::post('reviews', 'store');
});