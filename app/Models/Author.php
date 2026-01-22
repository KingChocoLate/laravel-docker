<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Author extends Model
{
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function articles(): HasMany {
        return $this->hasMany(Article::class);
    }

    public function comments(): MorphMany {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
    public function audiences(): HasManyThrough {
        return $this->hasManyThrough(Audience::class, Article::class);
    }
}