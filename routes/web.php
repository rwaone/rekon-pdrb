<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdrbController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FenomenaController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdjustmentController;
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

Route::get('/', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified']);

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

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
Route::post('rekonsiliasi/copy-data', [PdrbController::class, 'copyData'])->name('copyData');
Route::post('rekonsiliasi/submit-data', [PdrbController::class, 'submitData'])->name('submitData');
Route::post('rekonsiliasi/unsubmit-data', [PdrbController::class, 'unsubmitData'])->name('unsubmitData');
Route::resource('pdrb', PdrbController::class)->middleware(['auth', 'verified']);
Route::get('monitoring', [PdrbController::class, 'monitoring'])->middleware(['auth', 'verified']);

Route::post('adjustment/get-data', [AdjustmentController::class, 'show'])->middleware(['auth', 'verified'])->name('get-adjustment');
Route::post('adjustment/save-data', [AdjustmentController::class, 'update'])->middleware(['auth', 'verified'])->name('save-adjustment');

//Fenomena
Route::post('fenomena/get', [FenomenaController::class, 'getFenomena'])->middleware(['auth', 'verified'])->name('getFenomena');
Route::post('fenomena/save', [FenomenaController::class, 'saveFenomena'])->middleware(['auth', 'verified'])->name('saveFenomena');
Route::get('fenomena/viewAll', [FenomenaController::class, 'viewAll'])->middleware(['auth', 'verified'])->name('viewAll');
Route::get('fenomena/getData', [FenomenaController::class, 'getData'])->middleware(['auth', 'verified'])->name('fenomena.getData');
Route::get('fenomena/monitoring', [FenomenaController::class, 'monitoring'])->middleware(['auth', 'verified']);
Route::get('fenomena/getMonitoring', [FenomenaController::class, 'getMonitoring'])->middleware(['auth', 'verified'])->name('fenomena.getMonitoring');

// Route::resource('fenomena', FenomenaController::class)->middleware(['auth', 'verified']);

//Lapangan Usaha
Route::get('lapangan-usaha/rekonsiliasi', [LapanganController::class, 'rekonsiliasi'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/fenomena', [LapanganController::class, 'fenomena'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/diskrepansi', [LapanganController::class, 'konserda'])->middleware(['auth', 'verified']);
// Route::get('lapangan-usaha/getKonserda/{period_id}', [LapanganController::class, 'getKonserda'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/getKonserda', [LapanganController::class, 'getKonserda'])->middleware(['auth', 'verified'])->name('lapangan-usaha.getKonserda');
Route::get('lapangan-usaha/daftarPokok', [LapanganController::class, 'daftarPokok'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/detailPokok', [LapanganController::class, 'detailPokok'])->middleware(['auth', 'verified'])->name('lapangan-usaha.detail');
Route::get('lapangan-usaha/getDetail', [LapanganController::class, 'getDetail'])->middleware(['auth', 'verified'])->name('lapangan-usaha.getDetail');
Route::get('lapangan-usaha/hasil', [LapanganController::class, 'result'])->middleware(['auth', 'verified']);

Route::get('lapangan-usaha/adjustment', [AdjustmentController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/release', [LapanganController::class, 'release'])->middleware(['auth', 'verified']);

Route::get('lapangan-usaha/monitoring', [LapanganController::class, 'monitoring'])->middleware(['auth', 'verified']);
Route::get('lapangan-usaha/getMonitoring', [LapanganController::class, 'getMonitoring'])->middleware(['auth', 'verified'])->name('lapangan-usaha.getMonitoring');

//Pengeluaran
Route::get('pengeluaran/rekonsiliasi', [PengeluaranController::class, 'rekonsiliasi'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/diskrepansi', [PengeluaranController::class, 'konserda'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/fenomena', [PengeluaranController::class, 'fenomena'])->middleware(['auth', 'verified']);
// Route::get('pengeluaran/getKonserda/{period_id}', [PengeluaranController::class, 'getKonserda'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/getKonserda', [PengeluaranController::class, 'getKonserda'])->middleware(['auth', 'verified'])->name('pengeluaran.getKonserda');
Route::get('pengeluaran/daftarPokok', [PengeluaranController::class, 'daftarPokok'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/detailPokok', [PengeluaranController::class, 'detailPokok'])->middleware(['auth', 'verified'])->name('pengeluaran.detail');;
Route::get('pengeluaran/getDetail', [PengeluaranController::class, 'getDetail'])->middleware(['auth', 'verified'])->name('pengeluaran.getDetail');
Route::get('pengeluaran/adjustment', [AdjustmentController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/hasil', [PengeluaranController::class, 'result'])->middleware(['auth', 'verified']);

Route::get('pengeluaran/monitoring', [PengeluaranController::class, 'monitoring'])->middleware(['auth', 'verified']);
Route::get('pengeluaran/getMonitoring', [PengeluaranController::class, 'getMonitoring'])->middleware(['auth', 'verified'])->name('pengeluaran.getMonitoring');

Route::post('konserda/year', [PeriodController::class, 'konserdaYear'])->name('konserdaYear');
Route::post('konserda/quarter', [PeriodController::class, 'konserdaQuarter'])->name('konserdaQuarter');
Route::post('konserda/period', [PeriodController::class, 'konserdaPeriod'])->name('konserdaPeriod');


Route::post('fenomena/year', [PeriodController::class, 'fenomenaYear'])->name('fenomenaYear');
Route::post('fenomena/quarter', [PeriodController::class, 'fenomenaQuarter'])->name('fenomenaQuarter');

Route::post('fetch/year', [PeriodController::class, 'fetchYear'])->name('fetchYear');
Route::post('fetch/quarter', [PeriodController::class, 'fetchQuarter'])->name('fetchQuarter');
Route::post('fetch/period', [PeriodController::class, 'fetchPeriod'])->name('fetchPeriod');
Route::post('fetch/active-year', [PeriodController::class, 'fetcActiveYear'])->name('fetchActiveYear');
Route::post('fetch/active-quarter', [PeriodController::class, 'fetchActiveQuarter'])->name('fetchActiveQuarter');
Route::post('fetch/active-period', [PeriodController::class, 'fetchActivePeriod'])->name('fetchActivePeriod');
Route::resource('period', PeriodController::class)->middleware(['auth', 'verified', 'admin']);

Route::get('dataset/create/batch', [DatasetController::class, 'batchCreate'])->middleware('auth', 'admin');
Route::get('dataset/update/pdrb', [DatasetController::class, 'batchUpdatePdrb'])->middleware('auth', 'admin');

Route::resource('user', UserController::class)->middleware(['auth', 'admin']);


require __DIR__ . '/auth.php';
