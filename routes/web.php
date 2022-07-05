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
use App\Http\Controllers\kamarController;
use App\Http\Controllers\recordsController;
use App\Http\Controllers\obatController;
use App\Http\Controllers\peralatanController;
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

//peralatan
Route::get('/peralatan', function () {
    if (Auth::check()) {
        return peralatanController::index();
    }
    return loginController::index();
});
Route::get('/peralatan/add',function () {
    return peralatanController::add();
})->middleware('auth');
Route::post('/peralatan/add',function (Request $request) {
    return peralatanController::add_action($request);
})->middleware('auth');
Route::get('/peralatan/edit/{id}',function ($id) {
    return peralatanController::edit($id);
})->middleware('auth');
Route::get('/peralatan/pakai/{id}',function ($id) {
    return peralatanController::change_status($id);
})->middleware('auth');
Route::post('/peralatan/edit',function (Request $request) {
    return peralatanController::edit_action($request);
})->middleware('auth');
Route::get('/peralatan/delete/{id}',function ($id) {
    return peralatanController::delete($id);
})->middleware('auth');

//kamar
Route::get('/kamar', function () {
    if (Auth::check()) {
        return kamarController::index();
    }
    return loginController::index();
});
Route::get('/kamar/add',function () {
    return kamarController::add();
})->middleware('auth');
Route::post('/kamar/add',function (Request $request) {
    return kamarController::add_action($request);
})->middleware('auth');
Route::get('/kamar/edit/{id}',function ($id) {
    return kamarController::edit($id);
})->middleware('auth');
Route::post('/kamar/edit',function (Request $request) {
    return kamarController::edit_action($request);
})->middleware('auth');
Route::get('/kamar/delete/{id}',function ($id) {
    return kamarController::delete($id);
})->middleware('auth');


//records
Route::get('/records', function () {
    if (Auth::check()) {
        return recordsController::index();
    }
    return loginController::index();
});
Route::get('/records/add/{id}',function ($id) {
    return recordsController::add($id);
})->middleware('auth');
Route::post('/records/add',function (Request $request) {
    return recordsController::add_action($request);
})->middleware('auth');
Route::get('/records/gate/{id}',function ($id) {
    return recordsController::gate($id);
})->middleware('auth');
Route::post('/records/gate',function (Request $request) {
    return recordsController::detail($request);
})->middleware('auth');