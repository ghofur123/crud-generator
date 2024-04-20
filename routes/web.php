<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Pages\LembagaController;

use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\TemplateController;
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

Route::resource('/coba', CobaController::class);

Route::resource('/', DashboardController::class);
Route::resource('/lembaga', LembagaController::class);


Route::resource('/firebase', FirebaseController::class);

Route::get('/login', [TemplateController::class, 'login']);
Route::get('/dashboard', [TemplateController::class, 'dashboard']);
 // Route::post('/get-firebase-data', [FirebaseController::class, 'register']);
// Route::get('get-firebase-data', [FirebaseController::class, 'index'])->name('firebase.index');