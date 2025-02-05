<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Leaderboards Record</title>
</head>
<body>
<div class="container">
    <h1>Are you sure you want to delete this record?</h1>

    <!-- Forma za brisanje rekorda -->
    <form action="{{ route('leaderboards.delete', $leaderboard->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="user_id">User ID:</label>
            <input type="text" class="form-control" value="{{ $leaderboard->user_id }}" readonly>
        </div>

        <div class="form-group">
            <label for="points">Points:</label>
            <input type="number" class="form-control" value="{{ $leaderboard->points }}" readonly>
        </div>
        <button type="submit" class="btn btn-danger">Delete Leaderboards Record</button>
    </form>
        
    <!-- Link za povratak na listu leaderboards -->
    <a href="{{ route('leaderboards.index') }}" class="btn btn-secondary">Cancel</a>
</div>
</body>
</html>