<?php

use App\Http\Controllers\Api\ContactController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('contacts', [ContactController::class, 'index']);
Route::get('contacts/{id}', [ContactController::class, 'show']);
Route::post('contacts/', [ContactController::class, 'store']);
Route::put('contacts/{id}', [ContactController::class, 'update']);
Route::delete('contacts/{id}', [ContactController::class, 'destroy']);
