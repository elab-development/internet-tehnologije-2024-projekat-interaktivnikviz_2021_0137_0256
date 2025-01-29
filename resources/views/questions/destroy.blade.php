<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obriši pitanje</title>
</head>
<body>
<div class="container">
    <h2>Obriši pitanje</h2>

    <!-- Forma za brisanje pitanja -->
    <form action="{{ route('questions.destroy') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label for="question_id" class="form-label">Izaberi pitanje:</label>
            <select name="question_id" id="question_id" class="form-select" required>
                <option value="" disabled selected>-- Izaberi pitanje --</option>
                @foreach($questions as $question)
                    <option value="{{ $question->id }}">{{ $question->text }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-danger">Obriši</button>
    </form>
</div>
</body>
</html>