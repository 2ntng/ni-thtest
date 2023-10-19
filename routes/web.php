<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [BarangController::class, 'index']);

Route::controller(BarangController::class)->group(function () {
  Route::get('/ajax/getAll', 'getAll');
  Route::get('/ajax/getData/{id}', 'getData');
  Route::post('/ajax/addData', 'store');
  Route::post('/ajax/editData', 'edit');
  Route::post('/ajax/deleteData', 'destroy');
});


// Route::get('/ajax/getAll', [BarangController::class, 'getAll']);
// Route::get('/ajax/getData', [BarangController::class, 'getData']);