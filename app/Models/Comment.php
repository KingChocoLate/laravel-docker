<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo {
        return $this->morphTo();
    }
}
