<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;
use App\Http\Resources\LeaderboardResource;
use App\Models\User;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
{
    $leaderboards = Leaderboard::with('user')->orderByDesc('points')->get();
    return LeaderboardResource::collection($leaderboards);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'points' => 'required|integer|min:0',
    ]);

    $user = auth()->user(); // koristi ulogovanog korisnika

    $existing = Leaderboard::where('user_id', $user->id)->first();

    if ($existing) {
        if ($validated['points'] > $existing->points) {
            $existing->points = $validated['points'];
            $existing->save();
        }
        return new LeaderboardResource($existing);
    }

    $leaderboard = Leaderboard::create([
        'user_id' => $user->id,
        'points' => $validated['points'],
    ]);

    return new LeaderboardResource($leaderboard);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */

    /*public function show($leaderboard_id) OVO JE ZAKOMENTARISANO KAKO BI SE OMOGUCILI RESURSI!
    {
        $result = Leaderboard::find($leaderboard_id);
    if (is_null($result)){
        return response()->json('Rezultat nije pronađen', 404);
    }
    return response()->json($result); 
    }*/

    public function show(Leaderboard $leaderboard)
{
    $leaderboard->load('user'); // Učitava korisnika povezanog sa leaderboardomSS
    return new LeaderboardResource($leaderboard);
}

    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Leaderboard $leaderboard)
    {
        $users = User::all(); // Uzima sve korisnike iz baze
        return view('leaderboards.update', compact('leaderboard', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leaderboard $leaderboard)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:0',
        ]);
    
        $leaderboard->update($validated);
    
        return redirect()->route('leaderboards.index')->with('success', 'Leaderboard entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Leaderboard  $leaderboard
     * @return \Illuminate\Http\Response
     */

     public function showDeleteForm(Leaderboard $leaderboard)
     {
         return view('leaderboards.delete', compact('leaderboard'));
     }
    
    public function destroy(Leaderboard $leaderboard)
    {
        try {
            $leaderboard->delete();
            return redirect()->route('leaderboards.index')->with('success', 'Leaderboards record deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('leaderboards.index')->with('error', 'Failed to delete leaderboards record.');
        }
    }
}
