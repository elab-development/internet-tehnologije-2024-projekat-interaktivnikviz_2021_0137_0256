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

//Rute za koje ne treba privilegija
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::resource('questions', QuestionController::class)->only(['show', 'index']);

//Korisnicke rute
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    //Resursne rute za korisnike
    Route::resource('question_categories', QuestionCategoryController::class)->only(['show', 'index']);
    Route::resource('leaderboards', LeaderboardController::class)->only(['show']);


    // API ruta za logout korisnika
    Route::post('/logout', [AuthController::class, 'logout']);
});

//Administrator rute
Route::group(['middleware' => ['auth:sanctum','admin']], function () {
    Route::get('/admin/profile', function(Request $request) {
        return auth()->user();
    });
    Route::get('/admin/dashboard', function () {
        return response()->json(['message' => 'Welcome to admin dashboard']);
    });

    //Resursne rute za Administratora
    Route::resource('users', UserController::class);

    //Rute za brisanje
    Route::delete('/questions/{question}/delete', [QuestionController::class, 'destroy'])->name('questions.delete');
    Route::delete('/question_categories/{questionCategory}/delete', [QuestionCategoryController::class, 'destroy'])->name('question_categories.delete');
    //Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('users.delete');
    Route::delete('/leaderboards/{leaderboard}/delete', [LeaderboardController::class, 'destroy'])->name('leaderboards.delete');

    // API ruta za logout administatora
    Route::post('/logout', [AuthController::class, 'logout']);
});
