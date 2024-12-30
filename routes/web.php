<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pencarian\PencarianCT;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\Riwayat\RiwayatCT;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\RiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\Users\UsersCT;

// authentication
// tampilan untuk pengguna yang belum login
Route::get('/', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/register', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/forgot-password', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
Route::post('/login', [LoginBasic::class, 'login'])->name('login');

// post register user
Route::post('/registerstore', [RegisterBasic::class, 'store'])->name('register-user');

// tampilan untuk pengguna yang sudah login
// Route::middleware(['auth'])->group(function () {

// search
Route::get('/pencarian', [PencarianCT::class, 'index'])->name('pencarian');
Route::post('/search', [PencarianCT::class, 'search'])->name('search');

// riwayat
Route::get('/riwayat', [RiwayatCT::class, 'index'])->name('riwayat');
Route::get('/riwayat/data', [RiwayatCT::class, 'getData'])->name('riwayat.data');
Route::delete('/riwayat/delete/{id}', [RiwayatCT::class, 'delete'])->name('riwayat.delete');
// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/icons-ri', [RiIcons::class, 'index'])->name('icons-ri');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
// tables
Route::get('/users', [UsersCT::class, 'index'])->name('users');

// profile
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

//Logout
Route::post('/Logout', [LoginBasic::class, 'logout'])->name('logout');
// });