<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionCategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\API\AuthController;


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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::resource('questions', QuestionController::class)->only(['update', 'store', 'destroy']);

    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum','admin']], function () {
    Route::get('/admin/profile', function(Request $request) {
        return auth()->user();
    });
    Route::get('/admin/dashboard', function () {
        return response()->json(['message' => 'Welcome to admin dashboard']);
    });
});

//Privremeno premestene rute u web.php nakon rada sa Reactom vratiti ih ovde



/*Route::resource('questions', QuestionController::class);
Route::resource('leaderboards', LeaderboardController::class);
Route::resource('users', UserController::class);
Route::resource('question_categories', QuestionCategoryController::class);*/
