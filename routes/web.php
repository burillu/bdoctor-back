<?php

//use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\Admin\StatsController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile/', [ProfileController::class, 'edit'])->name("profile.edit");
    Route::get('sponsorships/', [SponsorshipController::class, 'index'])->name('sponsorships.index');
    Route::resource('leads', LeadController::class)->except('create','edit','store');
    Route::resource('reviews', ReviewController::class)->except('create','edit','store');
    Route::resource('profile', ProfileController::class)->except('create','edit','store','index');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/confirmation', [PaymentController::class, 'confirmation'])->name('payments.confirmation'); 
    Route::get('stats/', [StatsController::class, 'index'])->name('stats.index');
});


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';

Route::fallback(function () {
    return redirect()->route('admin.dashboard');
});
