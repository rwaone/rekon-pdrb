<?php

use App\Http\Controllers\FenomenaController;
use App\Http\Controllers\PdrbController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('rekonsiliasi', [PdrbController::class, 'rekonsiliasi'])->middleware(['auth', 'verified']);
Route::post('rekonsiliasi', [PdrbController::class, 'rekonsiliasi'])->middleware(['auth', 'verified']);
Route::resource('pdrb', PdrbController::class)->middleware(['auth', 'verified']);
Route::resource('fenomena', FenomenaController::class)->middleware(['auth', 'verified']);

//view PDRB list
Route::get('konserda', [PdrbController::class, 'konserda'])->middleware(['auth', 'verified']);
Route::get('getKonserda/{period_id}', [PdrbController::class, 'getKonserda'])->middleware(['auth', 'verified']);
Route::get('daftarPokok', [PdrbController::class, 'daftarPokok'])->middleware(['auth', 'verified']);

Route::post('fetch/year', [PeriodController::class, 'fetchYear'])->name('fetchYear');
Route::post('fetch/quarter', [PeriodController::class, 'fetchQuarter'])->name('fetchQuarter');
Route::post('fetch/period', [PeriodController::class, 'fetchPeriod'])->name('fetchPeriod');
Route::resource('period', PeriodController::class)->middleware(['auth', 'verified']);


require __DIR__.'/auth.php';
