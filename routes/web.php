<?php

//use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\ReviewController;

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
    // Route::get('leads/', [LeadController::class, 'index'])->name("leads.index");
    // Route::get('leads/{id}', [LeadController::class, 'show'])->name("leads.show");
    Route::resource('leads', LeadController::class)->except('create','edit','store');
    Route::get('reviews/', [ReviewController::class, 'index'])->name("reviews.index");
    Route::get('reviews/{id}', [ReviewController::class, 'show'])->name("reviews.show");
    Route::resource('profile', ProfileController::class)->except('create','edit','store','index');
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
