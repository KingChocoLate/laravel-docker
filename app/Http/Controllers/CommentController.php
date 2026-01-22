<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Audience;
use App\Models\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function createComment(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'exists:users,name'],
            'topic_type' => ['required', 'in:author,article,audience'],
            'topic_name' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        $user = User::where('name', $data['username'])->firstOrFail();

        $topic = match ($data['topic_type']) {
            'author' => Author::where('name', $data['topic_name'])->firstOrFail(),
            'article' => Article::where('name', $data['topic_name'])->firstOrFail(),
            'audience' => Audience::where('name', $data['topic_name'])->whereNull('article_id')->firstOrFail(),
        };

        $comment = $topic->comments()->create([
            'name' => $data['message'],
            'user_id' => $user->id,
        ]);

        return response()->json(compact('comment'), 201);
    }
}
