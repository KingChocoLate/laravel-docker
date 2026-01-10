<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function author(): BelongsTo {
        return $this->belongsTo(Author::class);
    }
    public function audiences(): HasMany {
        return $this->hasMany(Audience::class);
    }

    public function comments(): MorphMany {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
