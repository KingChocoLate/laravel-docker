<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function createArticle(Request $request)
    {
        $data = $request->validate([
            'author_name' => ['required', 'string'],
            'article_name' => ['required', 'string', 'max:255'],
        ]);

        $author = Author::where('name', $data['author_name'])->firstOrFail();

        $article = Article::create([
            'name' => $data['article_name'],
            'author_id' => $author->id,
        ]);

        return response()->json(compact('article'), 201);
    }
}
