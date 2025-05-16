<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:6',
        ]);


        if ($validator->fails())
            return response()->json($validator->errors());

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>'player',//default vrednost nam je player,a admini se rucno dodaju
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
		->json(['data' => $user, 'access_token' => $token,'token_type' => 'Bearer',]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) 
	  {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])-> 								 firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi ' . $user->username . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function loginAdmin(Request $request)
{
    if (!Auth::attempt($request->only('email', 'password')))  {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = Auth::user();

    if ($user->role !== 'admin') {
        return response()->json(['message' => 'Access denied: not an admin'], 403);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Hi ' . $user->username . ', welcome to admin home',
        'access_token' => $token,
        'token_type' => 'Bearer'
    ]);
}


   public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out successfully']);
}
}
