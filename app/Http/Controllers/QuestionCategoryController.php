<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use Illuminate\Http\Request;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = QuestionCategory::all();
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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

        // Validacija podataka
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        // Log a custom message
        \Log::info('After validation');

        try {
            $category = QuestionCategory::create([
                'name' => $validated['name'],
                'description' => $validated['description']
            ]);

            return response()->json([
                'message' => 'Category created successfully',
                'category' => $category
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
            \Log::error('Error creating category:', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }

        // Log a custom message
        \Log::info('After question creation');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuestionCategory  $questionCategory
     * @return \Illuminate\Http\Response
     */
    public function show($question_category_id)
    {
        $question_category = QuestionCategory::find($question_category_id);
        if (is_null($question_category)){
            return response()->json('Kategorija nije pronadjena', 404);
        }
        return response()->json($question_category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestionCategory  $questionCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionCategory $questionCategory)
    {
        return view('categories.update', compact('questionCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionCategory  $questionCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionCategory $questionCategory)
    {
    \Log::info('Request data:', $request->all());

    // Validacija podataka
    $validated = $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
    ]);
    \Log::info('Validation passed');

    try {
        // Update question category
        $questionCategory->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'message' => 'Question category updated successfully',
            'questionCategory' => $questionCategory
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
        \Log::error('Error updating question category:', ['error' => $e->getMessage()]);

        return response()->json([
            'message' => 'Failed to update question category',
            'error' => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuestionCategory  $questionCategory
     * @return \Illuminate\Http\Response
     */

    // Metod za prikazivanje forme za brisanje
    public function showDeleteForm(QuestionCategory $questionCategory)
    {
        return view('categories.delete', compact('questionCategory'));
    }

    public function destroy(QuestionCategory $questionCategory)
    {
        try {
            $questionCategory->delete();
            
            return redirect()->route('question_categories.index')->with('success', 'Question category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('question_categories.index')->with('error', 'Failed to delete question category.');
        }
    }
}
