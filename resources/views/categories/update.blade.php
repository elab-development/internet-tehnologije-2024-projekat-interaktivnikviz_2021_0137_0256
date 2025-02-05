<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update question category</title>
</head>
<body>
<div class="container">
    <h1>Update Question Category</h1>
    <form id="updateForm" action="{{ route('question_categories.update', $questionCategory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $questionCategory->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descrption:</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $questionCategory->description }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Question Category</button>
    </form>
</div>

</body>
</html>
