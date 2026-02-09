<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionCategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\LeaderboardExportController;
use App\Models\Leaderboard;
use App\Http\Resources\LeaderboardResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rute su organizovane po pravima pristupa: javne, korisničke i admin.
|
*/

// --- JAVNE RUTE (Rute za koje ne treba privilegija) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::resource('questions', QuestionController::class)->only(['show', 'index']);
Route::get('/quiz/random', [QuestionController::class, 'randomQuestions']);
Route::get('/quiz', [QuestionController::class, 'quiz']);
Route::get('/quiz/category/{category}', [QuestionController::class, 'randomByCategory']);


// --- KORISNIČKE RUTE (Rute za koje je potrebna autentifikacija) ---
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
    $user = auth()->user();
    $leaderboard = \App\Models\Leaderboard::where('user_id', $user->id)->first();

    return response()->json([
        'id' => $user->id,
        'username' => $user->username,
        'email' => $user->email,
        'points' => $leaderboard->points ?? 0,
        'avatar' => $user->avatar,
        'is_admin' => $user->role === 'admin',
    ]);
});
    //Rute za izmenu korisničkog profila
    Route::patch('/profile/update-username', [UserController::class, 'updateUsername']);
    Route::patch('/profile/update-password', [UserController::class, 'updatePassword']);


    //Ruta za preuzimanje korisničkog profilai pamcenje avatara
    Route::post('/profile/avatar', function(Request $request) {
        $user = auth()->user();
        $user->avatar = $request->avatar;
        $user->save();
        return response()->json(['message' => 'Avatar updated']);
    });


    //Resursne rute za korisnike
    Route::resource('question_categories', QuestionCategoryController::class)->only(['show', 'index']);
    Route::resource('leaderboards', LeaderboardController::class);

    // API ruta za logout korisnika
    Route::post('/logout', [AuthController::class, 'logout']);
});


// --- ADMIN RUTE (Rute za koje je potrebna autentifikacija i admin privilegije) ---
Route::group(['middleware' => ['auth:sanctum','admin']], function () {
    Route::get('/admin/profile', function(Request $request) {
        return auth()->user();
    });

    Route::get('/admin/dashboard', function () {
        return response()->json(['message' => 'Welcome to admin dashboard']);
    });

    //Ruta za preuzimanje leaderboarda (posebna ruta)
    Route::get('/leaderboards-export', [LeaderboardExportController::class, 'export']);

    //Resursne rute za Administratora
    Route::resource('users', UserController::class);
   
    Route::resource('questions', QuestionController::class)->except(['index', 'show']);
    Route::resource('question_categories', QuestionCategoryController::class)->except(['index', 'show']);
    
    //Rute za brisanje
    Route::delete('/questions/{question}/delete', [QuestionController::class, 'destroy'])->name('questions.delete');
    Route::delete('/question_categories/{questionCategory}/delete', [QuestionCategoryController::class, 'destroy'])->name('question_categories.delete');
    //Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('users.delete');
    Route::delete('/leaderboards/{leaderboard}/delete', [LeaderboardController::class, 'destroy'])->name('leaderboards.delete');

    // API ruta za logout administatora
    Route::post('/logout', [AuthController::class, 'logout']);
});
