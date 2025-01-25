<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionCategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\LeaderboardController;


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

//Zakomentarisane rute nisu potrebne jer imamo resource rute
//Route::get('/questions', [QuestionController::class, 'index']);
//Route::get('/questions/{id}', [QuestionController::class, 'show']);
Route::get('/question_categories', [QuestionCategoryController::class, 'index']);
Route::get('/question_categories/{id}', [QuestionCategoryController::class, 'show']);
//Route::get('/leaderboards', [LeaderboardController::class, 'index']);
//Route::get('/leaderboards/{id}', [LeaderboardController::class, 'show']);
Route::resource('questions', QuestionController::class);
Route::resource('leaderboards', LeaderboardController::class);
Route::resource('users', UserController::class);
//Route::get('/users', [UserController::class, 'index']);
//Route::get('/users/{id}', [UserController::class, 'show']);
