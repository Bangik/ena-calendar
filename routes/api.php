<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helpers\ResponseFormatter;

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

Route::fallback(function(){
    return ResponseFormatter::error(null, 'Page Not Found', 404);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/events', [EventController::class, 'store']);
Route::post('/eventss', [EventController::class, 'store2']);
Route::put('/events/{id}', [EventController::class, 'update']);
Route::put('/eventss/{id}', [EventController::class, 'update2']);
Route::delete('/events/{id}', [EventController::class, 'destroy']);
Route::post('/events/search', [EventController::class, 'search']);