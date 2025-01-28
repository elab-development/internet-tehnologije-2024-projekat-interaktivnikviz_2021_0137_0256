<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj novo pitanje</title>
</head>
<body>
    <h1>Dodaj novo pitanje</h1>
    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <label for="question">Pitanje:</label>
        <input type="text" name="question" required>

        <label for="category_id">Kategorija:</label>
        <select name="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="options">Opcije (JSON format):</label>
        <textarea name="options" required></textarea>

        <label for="answer">Tačan odgovor:</label>
        <input type="text" name="answer" required>

        <label for="points">Broj poena:</label>
        <input type="number" name="points" required>

        <button type="submit">Dodaj pitanje</button>
    </form>
</body>
</html>