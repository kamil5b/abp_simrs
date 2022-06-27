<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
use App\Http\Controllers\pasienController;
use App\Http\Controllers\obatController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\karyawanController;

Route::get('/', function () {
    if (Auth::check()) {
        return pasienController::index();
    }
    return loginController::index();
});
Route::post('/login', function (Request $request) {
    return loginController::authenticate($request);
});
Route::post('/logout', function (Request $request) {
    return loginController::logout($request);
});
Route::get('/register', function () {
    return view('register');
});
Route::post('/register', function (Request $request) {
    return loginController::register($request);
});

//PASIEN
Route::get('/pasien', function () {
    if (Auth::check()) {
        return pasienController::index();
    }
    return loginController::index();
});
Route::get('/pasien/add',function () {
    return pasienController::add();
})->middleware('auth');
Route::post('/pasien/add',function (Request $request) {
    return pasienController::add_action($request);
})->middleware('auth');
Route::get('/pasien/edit/{id}',function ($id) {
    return pasienController::edit($id);
})->middleware('auth');
Route::post('/pasien/edit',function (Request $request) {
    return pasienController::edit_action($request);
})->middleware('auth');
Route::get('/pasien/delete/{id}',function ($id) {
    return pasienController::delete($id);
})->middleware('auth');

//karyawan
Route::get('/karyawan', function () {
    if (Auth::check()) {
        return karyawanController::index();
    }
    return loginController::index();
});
Route::get('/karyawan/edit/{id}',function ($id) {
    return karyawanController::edit($id);
})->middleware('auth');
Route::post('/karyawan/edit',function (Request $request) {
    return karyawanController::edit_action($request);
})->middleware('auth');
Route::get('/karyawan/delete/{id}',function ($id) {
    return karyawanController::delete($id);
})->middleware('auth');

//obat
Route::get('/obat', function () {
    if (Auth::check()) {
        return obatController::index();
    }
    return loginController::index();
});
Route::get('/obat/add',function () {
    return obatController::add();
})->middleware('auth');
Route::post('/obat/add',function (Request $request) {
    return obatController::add_action($request);
})->middleware('auth');
Route::get('/obat/edit/{id}',function ($id) {
    return obatController::edit($id);
})->middleware('auth');
Route::post('/obat/edit',function (Request $request) {
    return obatController::edit_action($request);
})->middleware('auth');
Route::get('/obat/delete/{id}',function ($id) {
    return obatController::delete($id);
})->middleware('auth');