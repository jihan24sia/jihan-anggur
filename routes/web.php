<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MultipleuploadsController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});
Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/nama/{param1?}', function ($param1 = '') {
    return 'Nama saya: ' . $param1;
});
Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
})->name('route.about');

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


Route::resource('pelanggan', PelangganController::class);
// Detail Pelanggan
Route::get('/pelanggan/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');

// Upload file pendukung
Route::post('/pelanggan/{id}/upload-file', [PelangganController::class, 'uploadFile'])->name('pelanggan.uploadFile');

// Hapus file
Route::delete('/pelanggan/file/{id}', [PelangganController::class, 'deleteFile'])->name('pelanggan.deleteFile');

// Upload multiple file untuk pelanggan
Route::post('/pelanggan/{id}/upload', [PelangganController::class, 'uploadFile'])
    ->name('pelanggan.uploadFile');

// Hapus file yang sudah di-upload
Route::delete('/pelanggan/file/{id}', [PelangganController::class, 'deleteFile'])
    ->name('pelanggan.deleteFile');


Route::group(['middleware' => ['checkrole:Super Admin']], function () {
   Route::get('user', [UserController::class, 'index'])->name('user.list');

});


Route::resource('user', UserController::class);

Route::delete(
    '/user/{id}/delete-picture',
    [UserController::class, 'deletePicture']
)->name('user.delete-picture');

Route::get('/multipleuploads', [MultipleuploadsController::class, 'index'])->name('uploads');
Route::post('/save', [MultipleuploadsController::class, 'store'])->name('uploads.store');


Route::get('auth', [AuthController::class, 'index'])->name('auth');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

