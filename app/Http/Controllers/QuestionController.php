<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionResource;
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\Log;
use App\Events\QuestionCreated; 

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $query = Question::with('category');

    // Filter po kategoriji (id)
    if ($request->has('category_id') && $request->category_id != '') {
        $query->where('category_id', $request->category_id);
    }

    // Filter po minimalnim i maksimalnim poenima
    if ($request->has('min_points')) {
        $query->where('points', '>=', (int)$request->min_points);
    }
    if ($request->has('max_points')) {
        $query->where('points', '<=', (int)$request->max_points);
    }

    $questions = $query->paginate(15);

    return QuestionResource::collection($questions);
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

            event(new QuestionCreated($question)); // Okida se event posle pravljenja pitanja

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
     $question->load('category');
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
        $categories = QuestionCategory::all();
        return view('questions.update', compact('question', 'categories'));
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
    \Log::info('Entered update method');
    \Log::info('Request data:', $request->all());

    // Validacija podataka
    $validated = $request->validate([
        'category_id' => 'required|exists:question_categories,id',
        'question' => 'required|string',
        'options' => 'required|json',  // Validacija kao JSON string
        'answer' => 'required|string',
        'points' => 'required|integer|min:0',
    ]);
    \Log::info('Validation passed');

    // Decode JSON options
    $options = json_decode($validated['options'], true); // Dekodirajte JSON string
    if (json_last_error() !== JSON_ERROR_NONE) {
        \Log::error('Invalid JSON in options field');
        return response()->json([
            'message' => 'Invalid JSON format for options'
        ], 422);
    }

    \Log::info('Decoded options:', ['options' => $options]);

    try {
        // Update the question
        $question->update([
            'category_id' => $validated['category_id'],
            'question' => $validated['question'],
            'options' => json_encode($options), // Ponovno enkodirajte kao JSON
            'answer' => $validated['answer'],
            'points' => $validated['points'],
        ]);

        return response()->json([
            'message' => 'Question updated successfully',
            'question' => $question
        ], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Log validation errors
        \Log::error('Validation errors:', ['errors' => $e->errors()]);

        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        // Log any other errors during the update process
        \Log::error('Error updating question:', ['error' => $e->getMessage()]);

        return response()->json([
            'message' => 'Failed to update question',
            'error' => $e->getMessage()
        ], 500);
    }
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

    // Metod za prikazivanje forme za brisanje
public function showDeleteForm(Question $question)
{
    return view('questions.delete', compact('question'));
}

// Metod za brisanje pitanja
public function destroy(Question $question)
{
    try {
        $question->delete();

        return response()->json([
            'message' => 'Pitanje uspešno obrisano.'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Greška prilikom brisanja pitanja.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function randomQuestions()
{
    $questions = Question::inRandomOrder()->take(8)->with('category')->get();

    return QuestionResource::collection($questions);
}
public function quiz(Request $request)
{
    $type = $request->query('type', 'mix');
    $limit = (int) $request->query('limit', 10);

    $query = Question::with('category');

    if ($type === 'category') {
        $request->validate([
            'category_id' => 'required|exists:question_categories,id'
        ]);

        $query->where('category_id', $request->category_id);
    }

    $questions = $query
        ->inRandomOrder()
        ->take($limit)
        ->get();

    return QuestionResource::collection($questions);
}
public function randomByCategory($categoryId)
{
    $questions = Question::where('category_id', $categoryId)
        ->inRandomOrder()
        ->take(10)
        ->get();

    return response()->json(['data' => $questions]);
}


}
