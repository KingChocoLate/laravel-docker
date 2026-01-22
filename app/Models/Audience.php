<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Audience extends Model
{
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function article(): BelongsTo {
        return $this->belongsTo(Article::class);
    }

    public function comments(): MorphMany {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
