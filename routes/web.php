<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pencarian\PencarianCT;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\Riwayat\RiwayatCT;
use App\Http\Controllers\Users\UsersCT;
use App\Http\Controllers\WilayahController;

// middleware
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\PreventBack;

// authentication
Route::middleware([RedirectIfAuthenticated::class, PreventBack::class])->group(function () {
  // tampilan untuk pengguna yang belum login
  Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
  Route::get('/register', [RegisterBasic::class, 'index'])->name('auth-register-basic');
  Route::post('/login', [LoginBasic::class, 'login'])->name('login');
  Route::post('/users/activate/{id}', [UsersCT::class, 'activateUser'])->name('users.activate');


  // post register user
  Route::post('/registerstore', [RegisterBasic::class, 'store'])->name('register-user');
});


Route::middleware([Authenticate::class])->group(function () {
  // route yang diakses oleh admin dan user
// search
  Route::get('/pencarian', [PencarianCT::class, 'index'])->name('pencarian');
  Route::post('/search', [PencarianCT::class, 'search'])->name('search');

  // riwayat
  Route::get('/riwayat', [RiwayatCT::class, 'index'])->name('riwayat');
  Route::get('/riwayat/data', [RiwayatCT::class, 'getData'])->name('riwayat.data');
  Route::delete('/riwayat/delete/{id}', [RiwayatCT::class, 'delete'])->name('riwayat.delete');

  // profile
  Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('account-settings');
  Route::post('/pages/account-settings-account', [AccountSettingsAccount::class, 'update'])->name('account-settings.update');
  
  
  Route::post('/account-settings/delete-account', [AccountSettingsAccount::class, 'deleteAccount'])
    ->name('account-settings.delete-account');


  //Logout
  Route::post('/Logout', [LoginBasic::class, 'logout'])->name('logout');

  // get wilayah
Route::get('/get-kecamatan-karawang', [WilayahController::class, 'getKecamatan']);
Route::get('/get-desa', [WilayahController::class, 'getDesa']);

});

Route::middleware([Authenticate::class . ':admin'])->group(function () {
  // tables
  Route::get('/users', [UsersCT::class, 'index'])->name('users');
  Route::get('/users/data', [UsersCT::class, 'getData'])->name('users.data');

  Route::patch('/users/status/{id}', [UsersCT::class, 'updateStatus']);
  Route::post('/users/update-password', [UsersCT::class, 'updatePassword'])->name('users.update-password');
});