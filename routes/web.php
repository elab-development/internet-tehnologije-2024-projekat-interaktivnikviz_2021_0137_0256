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
Route::get('/questions/{question}/delete', [QuestionController::class, 'showDeleteForm'])->name('questions.showDeleteForm');
Route::delete('/questions/{question}/delete', [QuestionController::class, 'destroy'])->name('questions.delete');
Route::get('/question_categories/{questionCategory}/delete', [QuestionCategoryController::class, 'showDeleteForm'])->name('question_categories.showDeleteForm');
Route::delete('/question_categories/{questionCategory}/delete', [QuestionCategoryController::class, 'destroy'])->name('question_categories.delete');
Route::get('/users/{user}/delete/', [UserController::class, 'showDeleteForm'])->name('users.showDeleteForm');
Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('users.delete');
Route::get('/leaderboards/{leaderboard}/delete/', [LeaderboardController::class, 'showDeleteForm'])->name('leaderboards.showDeleteForm');
Route::delete('/leaderboards/{leaderboard}/delete', [LeaderboardController::class, 'destroy'])->name('leaderboards.delete');
Route::get('/', function () {
    return view('welcome');
});


