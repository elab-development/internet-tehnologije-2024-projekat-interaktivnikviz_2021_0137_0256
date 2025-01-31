<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Question</title>
</head>
<body>
<div class="container">
    <h1>Are you sure you want to delete this question?</h1>

    <!-- Forma za brisanje pitanja -->
    <form action="{{ route('questions.delete', $question->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="category_id">Category:</label>
            <input type="text" class="form-control" value="{{ $question->category->name }}" readonly>
        </div>

        <div class="form-group">
            <label for="question">Question:</label>
            <input type="text" class="form-control" value="{{ $question->question }}" readonly>
        </div>

        <div class="form-group">
            <label for="options">Options:</label>
            <textarea class="form-control" readonly>{{ json_encode($question->options) }}</textarea>
        </div>

        <div class="form-group">
            <label for="answer">Answer:</label>
            <input type="text" class="form-control" value="{{ $question->answer }}" readonly>
        </div>

        <div class="form-group">
            <label for="points">Points:</label>
            <input type="number" class="form-control" value="{{ $question->points }}" readonly>
        </div>

        <button type="submit" class="btn btn-danger">Delete Question</button>
    </form>

    <!-- Link za povratak na listu pitanja -->
    <a href="{{ route('questions.index') }}" class="btn btn-secondary">Cancel</a>
</div>
</body>
</html>