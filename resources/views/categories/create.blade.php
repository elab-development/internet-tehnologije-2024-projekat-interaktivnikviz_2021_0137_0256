<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj novu kategoriju</title>
</head>
<body>
    <h1>Dodaj novu kategoriju</h1>
    <form action="{{ route('question_categories.store') }}" method="POST">
        @csrf
        <label for="name">Kategorija:</label>
        <input type="text" name="name" required>

        <label for="description">Opis kategorije:</label>
        <input type="text" name="description" required>

        <button type="submit">Dodaj kategoriju</button>
    </form>
</body>
</html>