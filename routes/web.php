<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\AbsentController::class, 'index']);
Route::post('/validate-nik', [App\Http\Controllers\AbsentController::class, 'validateData']);
Route::post('/absent', [App\Http\Controllers\AbsentController::class, 'absent']);
Route::post('/pulang', [App\Http\Controllers\AbsentController::class, 'pulang']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');
Route::get('/data-absent', [App\Http\Controllers\HomeController::class, 'absent'])->middleware('auth');
Route::get('/edit-profile/{id}', [App\Http\Controllers\HomeController::class, 'editProfile'])->middleware('auth');
Route::patch('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfil'])->middleware('auth');

Route::get('/jabatan', [App\Http\Controllers\JabatanController::class, 'index'])->middleware('auth');
Route::post('/jabatan/tambah', [App\Http\Controllers\JabatanController::class, 'store'])->middleware('auth');
Route::get('/jabatan/hapus/{id}', [App\Http\Controllers\JabatanController::class, 'destroy'])->middleware('auth');
Route::get('/jabatan/ubah/{id}', [App\Http\Controllers\JabatanController::class, 'edit'])->middleware('auth');
Route::patch('/jabatan/perbarui/{id}', [App\Http\Controllers\JabatanController::class, 'update'])->middleware('auth');

Route::get('/karyawan', [App\Http\Controllers\KaryawanController::class, 'index'])->middleware('auth');
Route::post('/karyawan/tambah', [App\Http\Controllers\KaryawanController::class, 'store'])->middleware('auth');
Route::get('/karyawan/edit/{id}', [App\Http\Controllers\KaryawanController::class, 'edit'])->middleware('auth');
Route::patch('/karyawan/perbarui/{id}', [App\Http\Controllers\KaryawanController::class, 'update'])->middleware('auth');
Route::get('/karyawan/hapus/{id}', [App\Http\Controllers\KaryawanController::class, 'destroy'])->middleware('auth');

Route::get('/absensi', [App\Http\Controllers\AbsentDataController::class, 'index'])->middleware('auth');
Route::get('/test', [App\Http\Controllers\AbsentDataController::class, 'test'])->middleware('auth');
Route::get('/absensi/image/{id}', [App\Http\Controllers\AbsentDataController::class, 'showImage'])->middleware('auth');
Route::patch('/absensi/absent-manual/{id}/{date}', [App\Http\Controllers\AbsentDataController::class, 'absentManual'])->middleware('auth');

Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->middleware('auth');
Route::post('/laporan/export', [App\Http\Controllers\LaporanController::class, 'export'])->middleware('auth');
