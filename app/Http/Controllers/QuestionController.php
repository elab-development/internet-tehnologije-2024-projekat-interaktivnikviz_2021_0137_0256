<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\Log; // Ensure Log facade is imported

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return $questions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = QuestionCategory::all();
    return view('questions.create', compact('categories'));
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

        // Decode the options field
        $request->merge(['options' => json_decode($request->input('options'), true)]);

        // Validacija podataka
        $validated = $request->validate([
            'category_id' => 'required|exists:question_categories,id',
            'question' => 'required|string',
            'options' => 'required|array',
            'answer' => 'required|string',
            'points' => 'required|integer|min:0',
        ]);

        // Log a custom message
        \Log::info('After validation');

        try {
            $question = Question::create([
                'category_id' => $validated['category_id'],
                'question' => $validated['question'],
                'options' => json_encode($validated['options']), // Laravel će ovo automatski konvertovati
                'answer' => $validated['answer'],
                'points' => $validated['points'],
            ]);

            return response()->json([
                'message' => 'Question created successfully',
                'question' => $question
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            \Log::error('Validation errors:', ['errors' => $e->errors()]);

            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log any other errors during the creation process
            \Log::error('Error creating question:', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to create question',
                'error' => $e->getMessage()
            ], 500);
        }

        // Log a custom message
        \Log::info('After question creation');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */

    /*public function show($question_id) OVO JE ZAKOMENTARISANO ZA SVAKI SLUCAJ, I OVO RADI NESTO!
    {
        $question = Question::find($question_id);
    if (is_null($question)){
        return response()->json('Pitanje nije pronadjeno', 404);
    }
    //return response()->json($question);
    
    return new QuestionResource($question);
    }*/

    public function show(Question $question)
{
    return new QuestionResource($question);
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */

    //Delete view treba da prikaze formu za brisanje pitanja, ali ruta ocigledno ne funkcionise.
    /*public function deleteView()
    {
        $questions = Question::all(); // Dohvata sva pitanja iz baze
        return view('questions.destroy', compact('questions'));
    }*/

    public function destroy(Question $question)
    {
        Question::destroy($question->id);
        return response()->json('Question deleted successfully');
    }
}
