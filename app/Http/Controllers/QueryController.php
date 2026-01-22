<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Author;
use App\Models\Audience;
use App\Models\Comment;

class QueryController extends Controller
{
    public function getArticlesByAuthor(string $authorName)
    {
        $author = Author::where('name', $authorName)->with('articles')->firstOrFail();
        return response()->json($author->articles);
    }

    public function getAudiencesByArticle(string $articleName)
    {
        $article = Article::where('name', $articleName)->firstOrFail();
        $audiences = Audience::where('article_id', $article->id)->get();
        return response()->json($audiences);
    }

    public function getAudiencesByAuthor(string $authorName)
    {
        $author = Author::where('name', $authorName)->firstOrFail();
        return response()->json($author->audiences);
    }

    public function getCommentsByAudience(string $audienceName)
    {
        $aud = Audience::where('name', $audienceName)->with('comments')->firstOrFail();
        return response()->json($aud->comments);
    }
    
    public function getAllCommentsWithTopic()
    {
        $comments = Comment::with('commentable')->get();
        return response()->json($comments);
    }
}
