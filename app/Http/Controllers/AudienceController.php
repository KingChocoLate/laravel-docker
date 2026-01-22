<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Audience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AudienceController extends Controller
{
    public function createAudience(Request $request)
    {
        $data = $request->validate([
            'audience_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,name'],
            'password' => ['nullable', 'string', 'min:4'],
        ]);

        $user = User::create([
            'name' => $data['username'],
            'email' => $data['username'] . '@app.test',
            'password' => Hash::make($data['password'] ?? 'password'),
        ]);

        $audience = Audience::create([
            'name' => $data['audience_name'],
            'user_id' => $user->id,
            'article_id' => null,
        ]);

        return response()->json(compact('audience', 'user'), 201);
    }
}
