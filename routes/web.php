<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\KasirController;


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
    return view('welcome');
});
Route::group(['middleware' => ['auth','cek_role:admin,manager,kasir']], function(){
    Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');
});

//admin
Route::group(['middleware' => ['auth','cek_role:admin']], function(){
    Route::get('indexadmin',[AdminController::class, 'indexadmin'])->name('indexadmin');
    Route::get('createuser',[AdminController::class, 'createuser'])->name('createuser');
    Route::post('postuser',[AdminController::class, 'postuser'])->name('postuser');
    Route::get('edituser/{id}',[AdminController::class, 'edituser'])->name('edituser');
    Route::put('updateuser/{id}',[AdminController::class, 'updateuser'])->name('updateuser');
    Route::get('destroyuser/{id}',[AdminController::class, 'destroyuser'])->name('destroyuser');
});


//manager
Route::group(['middleware' => ['auth','cek_role:manager']], function(){
    Route::get('indexm',[ManagerController::class, 'indexm'])->name('indexm');
    Route::get('createm',[ManagerController::class, 'createm'])->name('createm');
    Route::post('store',[ManagerController::class, 'store'])->name('store');
    Route::get('editm/{id_menu}',[ManagerController::class, 'editm'])->name('editm');
    Route::put('updatem/{id_menu}',[ManagerController::class, 'updatem'])->name('updatem');
    Route::get('destroym/{id_menu}',[ManagerController::class, 'destroym'])->name('destroym');
    Route::get('laporan',[ManagerController::class, 'laporan'])->name('laporan');
});

//kasir
Route::group(['middleware' => ['auth','cek_role:kasir']], function(){ 
    Route::get('indexk',[KasirController::class, 'indexk'])->name('indexk');
    Route::get('createk',[KasirController::class, 'createk'])->name('createk');
    Route::post('storek',[KasirController::class, 'storek'])->name('storek');
});

//login
Route::get('login',[LoginController::class, 'index'])->name('login');
Route::Post('authenticate',[LoginController::class, 'authenticate'])->name('authenticate');

//logout
Route::get('logout',[LoginController::class, 'logout'])->name('logout');

//coba







