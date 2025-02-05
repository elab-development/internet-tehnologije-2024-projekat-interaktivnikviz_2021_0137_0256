<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update leaderboards record</title>
</head>
<body>
<div class="container">
    <h1>Update Leaderboards Record</h1>
    <form id="updateForm" action="{{ route('leaderboards.update', $leaderboard->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="user_id">User</label>
            <input type="text" class="form-control" value="{{ $leaderboard->user->username }}" disabled>
            <input type="hidden" name="user_id" value="{{ $leaderboard->user_id }}">
        </div>


        <div class="form-group">
            <label for="points">Points:</label>
            <input type="number" name="points" id="points" class="form-control" value="{{ $leaderboard->points }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Question Category</button>
    </form>
</div>

</body>
</html>
