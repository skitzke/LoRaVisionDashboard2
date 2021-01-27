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

Auth::routes(['verify'=>true]);

Route::get('/', function () {
    if(Auth::check()) {
        return redirect()->route('home');
    }
    return view('auth/login');
})->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); //->middleware('verified');

Route::resource('/admin/users', 'App\Http\Controllers\Admin\UsersController', ['except' => ['create', 'store', 'show']]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'stations'])->name('home'); //->middleware('verified');

Route::get('/settings', [App\Http\Controllers\General\SettingsController::class, 'index'])->name('settings_index'); // ->middleware('verified');;

Route::get('/disabled', [App\Http\Controllers\HomeController::class, 'disabled'])->name('disabled');

Route::post('/settings/update_name', [App\Http\Controllers\General\SettingsController::class, 'update_name'])->name('update_name');

Route::post('/settings/update_email', [App\Http\Controllers\General\SettingsController::class, 'update_email'])->name('update_email');

Route::post('/settings/update_password', [App\Http\Controllers\General\SettingsController::class, 'update_password'])->name('update_password');

Route::delete('/settings/delete_account', [App\Http\Controllers\General\SettingsController::class, 'delete_account'])->name('delete_account');

Route::post('/settings/update_avatar', [App\Http\Controllers\General\SettingsController::class, 'update_avatar'])->name('update_avatar');

Route::post('/home/addStation', [App\Http\Controllers\General\ApiController::class, 'addStations'])->name('addStations');

Route::post('/home/addVehicle', [App\Http\Controllers\General\ApiController::class, 'addVehicles'])->name('addVehicles');

Route::post('/home/addSensor', [App\Http\Controllers\General\ApiController::class, 'addSensors'])->name('addSensors');

Route::post('/home/editStation', [App\Http\Controllers\General\ApiController::class, 'editStations'])->name('editStations');

Route::post('/home/editVehicle', [App\Http\Controllers\General\ApiController::class, 'editVehicles'])->name('editVehicles');

Route::post('/home/deleteVehicle', [App\Http\Controllers\General\ApiController::class, 'deleteVehicle'])->name('deleteVehicle');

Route::post('/home/deleteStation', [App\Http\Controllers\General\ApiController::class, 'deleteStation'])->name('deleteStation');

Route::get('/admin/stationEdit', [App\Http\Controllers\Admin\EditController::class, 'index'])->name('edit_index');

Route::post('/home/resolveAlert', [App\Http\Controllers\General\ApiController::class, 'resolveAlert'])->name('resolve');

Route::post('/home/reset', [App\Http\Controllers\General\ApiController::class, 'restRelay'])->name('reset');

Route::post('/home/addVehicleType', [App\Http\Controllers\General\ApiController::class, 'addVehicleType'])->name('addVehicleType');

Route::post('/home/editVehicleType', [App\Http\Controllers\General\ApiController::class, 'editVehicleType'])->name('editVehicleType');

Route::post('/home/deleteVehicleType', [App\Http\Controllers\General\ApiController::class, 'deleteVehicleType'])->name('deleteVehicleType');
