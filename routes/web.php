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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*Route::get('/admin/users', [App\Http\Controllers\Admin\UsersController::class, 'users'])->name('getUsers');*/
Route::resource('/admin/users', 'App\Http\Controllers\Admin\UsersController', ['except' => ['create', 'store', 'show']]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'stations'])->name('home');

Route::get('/settings', [App\Http\Controllers\General\SettingsController::class, 'index'])->name('settings_index');

Route::get('/disabled', [App\Http\Controllers\HomeController::class, 'disabled'])->name('disabled');

Route::post('/settings/update_name', [App\Http\Controllers\General\SettingsController::class, 'update_name'])->name('update_name');

Route::post('/settings/update_email', [App\Http\Controllers\General\SettingsController::class, 'update_email'])->name('update_email');

Route::post('/settings/update_password', [App\Http\Controllers\General\SettingsController::class, 'update_password'])->name('update_password');

Route::delete('/settings/delete_account', [App\Http\Controllers\General\SettingsController::class, 'delete_account'])->name('delete_account');

Route::post('/settings/update_avatar', [App\Http\Controllers\General\SettingsController::class, 'update_avatar'])->name('update_avatar');
