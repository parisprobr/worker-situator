<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SituatorController;

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

Route::group([ 'middleware' => ['auth:sanctum']], function (){
    Route::post('/user/create', [UserController::class, 'store']);
    Route::post('/user/createToken', [UserController::class, 'createToken']);
    Route::post('/situator/people/create', [SituatorController::class, 'createPeople']);
    Route::post('/situator/people/{cpf}/image', [SituatorController::class, 'setPeopleImage']);
    Route::get('/situator/people/{cpf}', [SituatorController::class, 'getPeopleByCpf']);
    Route::delete('/situator/people/{cpf}', [SituatorController::class, 'deletePeopleByCpf']);
});
