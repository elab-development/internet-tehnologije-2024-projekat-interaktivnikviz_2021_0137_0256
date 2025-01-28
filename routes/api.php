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

//Privremeno premestene rute u web.php nakon rada sa Reactom vratiti ih ovde



/*Route::resource('questions', QuestionController::class);
Route::resource('leaderboards', LeaderboardController::class);
Route::resource('users', UserController::class);
Route::resource('question_categories', QuestionCategoryController::class);*/

