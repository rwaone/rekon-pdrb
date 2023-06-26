<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdrbController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FenomenaController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PengeluaranController;

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
    return view('dashboard');
})->middleware(['auth', 'verified']);

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
Route::post('rekonsiliasi/save-single', [PdrbController::class, 'saveSingleData'])->name('saveSingleData');
Route::post('rekonsiliasi/save-full', [PdrbController::class, 'saveFullData'])->name('saveFullData');
Route::post('rekonsiliasi/get-single', [PdrbController::class, 'getSingleData'])->name('getSingleData');
Route::post('rekonsiliasi/get-full', [PdrbController::class, 'getFullData'])->name('getFullData');
Route::resource('pdrb', PdrbController::class)->middleware(['auth', 'verified']);
Route::get('monitoring', [PdrbController::class, 'monitoring'])->middleware(['auth', 'verified']);

//Fenomena
Route::post('fenomena/get', [FenomenaController::class, 'getFenomena'])->middleware(['auth', 'verified'])->name('getFenomena');
Route::resource('fenomena', FenomenaController::class)->middleware(['auth', 'verified']);

//Lapangan
Route::get('lapangan-usaha/rekonsiliasi', [LapanganController::class, 'rekonsiliasi'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/fenomena', [LapanganController::class, 'fenomena'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/konserda', [LapanganController::class, 'konserda'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/getKonserda/{period_id}', [LapanganController::class, 'getKonserda'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/daftarPokok', [LapanganController::class, 'daftarPokok'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/detailPokok', [LapanganController::class, 'detailPokok'])->middleware(['auth', 'verified'])->name('lapangan-usaha.detail');

//Pengeluaran
Route::get('pengeluaran/rekonsiliasi', [PengeluaranController::class, 'rekonsiliasi'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/konserda', [PengeluaranController::class, 'konserda'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/fenomena', [PengeluaranController::class, 'fenomena'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/getKonserda/{period_id}', [PengeluaranController::class, 'getKonserda'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/daftarPokok', [PengeluaranController::class, 'daftarPokok'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/detailPokok', [PengeluaranController::class, 'detailPokok'])->middleware(['auth', 'verified'])->name('pengeluaran.detail');


Route::post('konserda/year', [PeriodController::class, 'konserdaYear'])->name('konserdaYear');
Route::post('konserda/quarter', [PeriodController::class, 'konserdaQuarter'])->name('konserdaQuarter');
Route::post('konserda/period', [PeriodController::class, 'konserdaPeriod'])->name('konserdaPeriod');

Route::post('fetch/year', [PeriodController::class, 'fetchYear'])->name('fetchYear');
Route::post('fetch/quarter', [PeriodController::class, 'fetchQuarter'])->name('fetchQuarter');
Route::post('fetch/period', [PeriodController::class, 'fetchPeriod'])->name('fetchPeriod');
Route::resource('period', PeriodController::class)->middleware(['auth', 'verified', 'admin']);

Route::resource('user', UserController::class)->middleware(['auth', 'verified', 'admin']);


require __DIR__ . '/auth.php';
