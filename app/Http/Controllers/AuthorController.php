<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    public function createAuthor(Request $request)
    {
        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,name'],
            'password' => ['nullable', 'string', 'min:4'],
        ]);

        $user = User::create([
            'name' => $data['username'],
            'email' => $data['username'] . '@app.test',
            'password' => Hash::make($data['password'] ?? 'password'),
        ]);

        $author = Author::create([
            'name' => $data['author_name'],
            'user_id' => $user->id,
        ]);

        return response()->json(compact('author', 'user'), 201);
    }
}
