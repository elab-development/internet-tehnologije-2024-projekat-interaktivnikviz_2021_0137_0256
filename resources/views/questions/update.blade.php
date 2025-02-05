<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update question</title>
</head>
<body>
<div class="container">
    <h1>Update Question</h1>
    <form id="updateForm" action="{{ route('questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $question->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" name="question" id="question" class="form-control" value="{{ $question->question }}" required>
        </div>

        <div class="form-group">
            <label for="options">Options (JSON format)</label>
            <textarea name="options" id="options" class="form-control" required>{{ old('options', json_encode($question->options)) }}</textarea>
        </div>

        <div class="form-group">
            <label for="answer">Answer</label>
            <input type="text" name="answer" id="answer" class="form-control" value="{{ $question->answer }}" required>
        </div>

        <div class="form-group">
            <label for="points">Points</label>
            <input type="number" name="points" id="points" class="form-control" value="{{ $question->points }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Question</button>
    </form>
</div>

<script>
    window.addEventListener('load', function() {
        // Opcije treba biti validan JSON string
        var optionsField = document.getElementById('options');
        var optionsValue = optionsField.value.trim();

        try {
            // Proveravamo da li su opcije validan JSON
            JSON.parse(optionsValue);
        } catch (e) {
            console.error('Invalid JSON format in options:', e);
        }
    });

    document.getElementById('updateForm').addEventListener('submit', function(event) {
        console.log('Form submitted');
        // Možete dodati više logova za praćenje procesa slanja forme
    });
</script>

</body>
</html>
