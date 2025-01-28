<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionCategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\LeaderboardController;

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

Route::resource('questions', QuestionController::class);
Route::resource('leaderboards', LeaderboardController::class);
Route::resource('users', UserController::class);
Route::resource('question_categories', QuestionCategoryController::class);

Route::get('/', function () {
    return view('welcome');
});


