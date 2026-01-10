<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public functions user(): BelongsTo {
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