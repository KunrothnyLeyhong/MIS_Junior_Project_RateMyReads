<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'user_id', 'rating', 'review', 'hidden'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes() {
    return $this->hasMany(Like::class);
}

public function likedBy(User $user) {
    return $this->likes()->where('user_id', $user->id)->exists();
}

public function comments()
{
    return $this->hasMany(ReviewComment::class);
}
public function reports()
{
    return $this->morphMany(Reports::class, 'reportable');
}

// Add scope for visible reviews
public function scopeVisible($query)
{
    return $query->where('hidden', 0);
}


}

