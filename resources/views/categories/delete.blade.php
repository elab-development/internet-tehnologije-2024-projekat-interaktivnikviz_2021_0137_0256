<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Question Category</title>
</head>
<body>
<div class="container">
    <h1>Are you sure you want to delete this question category?</h1>

    <!-- Forma za brisanje pitanja -->
    <form action="{{ route('question_categories.delete', $questionCategory->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="category_id">Category name:</label>
            <input type="text" class="form-control" value="{{ $questionCategory->name }}" readonly>
        </div>

        <div class="form-group">
            <label for="question">Category description:</label>
            <input type="text" class="form-control" value="{{ $questionCategory->description }}" readonly>
        </div>
        <button type="submit" class="btn btn-danger">Delete Category</button>
    </form>
        
    <!-- Link za povratak na listu pitanja -->
    <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
</div>
</body>
</html>