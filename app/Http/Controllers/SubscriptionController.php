<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Audience;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'exists:users,name'],
            'article_names' => ['required', 'array', 'min:1'],
            'article_names.*' => ['string'],
        ]);

        $user = User::where('name', $data['username'])->firstOrFail();

        $profile = Audience::where('user_id', $user->id)->whereNull('article_id')->firstOrFail();

        $subscriptions = [];
        foreach ($data['article_names'] as $articleName) {
            $article = Article::where('name', $articleName)->firstOrFail();

            $subscriptions[] = Audience::firstOrCreate(
                ['user_id' => $user->id, 'article_id' => $article->id],
                ['name' => $profile->name]
            );
        }

        return response()->json(['subscriptions' => $subscriptions]);
    }
}
