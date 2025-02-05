<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
<div class="container">
    <h1>Are you sure you want to delete this user?</h1>

    <!-- Forma za brisanje korisnika -->
    <form action="{{ route('users.delete', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
        </div>

        <div class="form-group">
            <label for="role">Role:</label>
            <input type="text" class="form-control" value="{{ $user->role }}" readonly>
        </div>

        <button type="submit" class="btn btn-danger">Delete User</button>
    </form>
        
    <!-- Link za povratak na listu korisnika -->
    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
</div>
</body>
</html>