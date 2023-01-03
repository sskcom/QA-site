<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::resource('tasks', TaskController::class)->only(['index']);

// Route::get('/pagination',  'App\Http\Controllers\TaskController@show');
Route::post('/pagination','App\Http\Controllers\QuestionsController@show');

Route::post('/register','App\Http\Controllers\RegisterController@register');
Route::post('/login','App\Http\Controllers\RegisterController@login');
Route::post('/logout','App\Http\Controllers\RegisterController@logout');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

