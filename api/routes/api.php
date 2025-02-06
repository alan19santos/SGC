<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CondominiumController;
use App\Http\Controllers\TowerController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\VisitorsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('user')->group(function () {
        Route::post('', [UserController::class, 'store']);
        Route::get('', [UserController::class, 'index']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/profile/{id}', [UserController::class, 'getProfileUser']);
    });

    Route::prefix('resident')->group(function () {
        Route::post('', [ResidentController::class, 'store']);
        Route::get('', [ResidentController::class, 'index']);
        Route::put('/{id}', [ResidentController::class, 'update']);
        Route::put('/beforeUpdate/{id}', [ResidentController::class, 'beforeUpdate']);
        Route::get('/{id}', [ResidentController::class, 'show']);
        Route::post('/update-image/{id}', [ResidentController::class, 'updateImage']);
        Route::get('/getImageUsers/{id}', [ResidentController::class, 'getImageUsers']);

    });

    Route::prefix('condominium')->group(function () {
        Route::post('/', [CondominiumController::class, 'store']);
        Route::get('', [CondominiumController::class, 'index']);
        Route::put('/{id}', [CondominiumController::class, 'update']);
        Route::get('/{id}', [CondominiumController::class, 'show']);
    });

    Route::prefix('tower')->group(function () {
        Route::post('/', [TowerController::class, 'store']);
        Route::get('', [TowerController::class, 'index']);
        Route::put('/{id}', [TowerController::class, 'update']);
        Route::get('/{id}', [TowerController::class, 'show']);
        Route::get('/getTowerCondominium/{id}', [TowerController::class, 'getTowerCondominium']);
    });

    //ApartmentController
    Route::prefix('apartment')->group(function () {
        Route::post('/', [ApartmentController::class, 'store']);
        Route::get('', [ApartmentController::class, 'index']);
        Route::put('/{id}', [ApartmentController::class, 'update']);
        Route::get('/{id}', [ApartmentController::class, 'show']);
        Route::get('/getTowerApartment/{id}', [ApartmentController::class, 'getTowerApartment']);
    });

    Route::prefix('serviceProvider')->group(function () {
        Route::post('/',[ServiceProviderController::class, 'store']);
        Route::get('', [ServiceProviderController::class, 'index']);
        Route::put('/{id}', [ServiceProviderController::class, 'update']);
        Route::get('/{id}', [ServiceProviderController::class, 'show']);
    });

    Route::prefix('visitors')->group(function () {
        Route::post('', [VisitorsController::class, 'store']);
        Route::get('', [VisitorsController::class, 'index']);
        Route::put('/{id}', [VisitorsController::class, 'update']);
        Route::get('/{id}', [VisitorsController::class, 'show']);
        // Route::get('/getAllVisitor', [VisitorsController::class, 'getVisitorCondominium']);
    });
   

    Route::prefix('status')->group(function () {
        Route::get('', [StatusController::class, 'index']);
    });

    Route::prefix('drive')->group(function () {
        Route::get('', [DriveController::class, 'index']);
    });


    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'index']);
    });

    
});
