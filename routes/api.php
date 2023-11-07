<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LembagasController;
use App\Http\Controllers\API\SiswaController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ImagesController;
use App\Http\Controllers\API\SiswaExcelController;
use App\Http\Controllers\API\SiswaPdfController;
use App\Http\Controllers\API\FirebaseController;
use App\Http\Controllers\API\ProfileFirebaseController;
use App\Http\Controllers\API\LoginFirebaseController;
use App\Http\Controllers\API\FirebaseFileController;
use App\Http\Controllers\API\ProductFirebaseController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('lembaga', LembagasController::class);
Route::apiResource("siswa", SiswaController::class);
Route::apiResource("images", ImagesController::class);
Route::apiResource("profile", ProfileFirebaseController::class);


// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user-update/{id}', [AuthController::class, 'update']);
});


Route::post('/import-siswa', [SiswaExcelController::class, 'import']);
Route::get('/export-siswa', [SiswaExcelController::class, 'export']);
Route::get('/export-siswa', [SiswaExcelController::class, 'export']);

Route::get('/pdf-siswa', [SiswaPdfController::class, 'generateSiswaPdf']);

Route::apiResource('/firebase', FirebaseController::class);
Route::apiResource('/firebase-image', FirebaseFileController::class);




Route::post('/login/register', [LoginFirebaseController::class, 'register']);
Route::post('/login/login', [LoginFirebaseController::class, 'login']);


Route::apiResource('/product', ProductFirebaseController::class);



