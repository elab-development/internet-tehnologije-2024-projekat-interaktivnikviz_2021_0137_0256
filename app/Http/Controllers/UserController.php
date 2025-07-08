<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\LeaderboardController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function show($user_id)
{
    $user = User::find($user_id);
    if (is_null($user)){
        return response()->json('Korisnik nije pronađen', 404);
    }
    return response()->json($user);     
} 


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Log the request data for debugging
        \Log::info('Request data:', $request->all());
        
        try{
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);} catch (\Exception $e) {
            return redirect()->back()->with('error', 'Greška prilikom validacije podataka');
        }

        // Log a custom message
        \Log::info('After validation');
    
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

         // Pozivamo store metodu LeaderboardController-a
        $leaderboardController = new LeaderboardController();
        $leaderboardController->store($user);
    
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);
    
        $user->username = $validated['username'];
        $user->email = $validated['email'];
    
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
    
        $user->save();
    
        return redirect()->route('users.update', $user)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

     public function showDeleteForm(User $user)
     {
         return view('users.delete', compact('user'));
     }

     public function destroy(User $user)
     {
         try {
             $user->delete();
             return response()->json(['message' => 'User deleted successfully'], 200);
         } catch (\Exception $e) {
             return response()->json(['message' => 'Failed to delete user'], 500);
         }
     }
     
 public function profile(Request $request)
    {
        $user = $request->user();

        $leaderboard = $user->leaderboard; // assuming relation is defined

        return response()->json([
            'username' => $user->username,
            'email' => $user->email,
            'points' => $leaderboard?->points ?? 0,
        ]);
    }
    
}
