<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
//use App\Models\Chirp;

// DB::listen(function ($query) {
//     dump($query->sql);
// }); 


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


route::view('/', 'welcome')->name('welcome');


// Route::get('/chirps', function () {
//     return view('chirps.index');
// }) ->name('chirps.index');



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    route::view('/dashboard', 'dashboard' )->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/chirps', [ChirpController::class, 'index']) ->name('chirps.index');

    route::post('/chirps', [ChirpController::class, 'store']) ->name('chirps.store');
    route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']) ->name ('chirps.edit');
    route::put('/chirps/{chirp}', [ChirpController::class, 'update']) ->name ('chirps.update');
    route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']) ->name ('chirps.destroy');
});

require __DIR__.'/auth.php';
