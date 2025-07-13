<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // Define the table if it is not the plural of the model name
    protected $table = 'books';
    protected $primaryKey = 'id';  // <-- tell Eloquent the PK column

    // Define the fillable properties (columns that are mass assignable)
    protected $fillable = [
        'title',
        'author',
        'genre',
        'pages',
        'published_date',
        'description',
        'image',
        'status',
    ];
    
    public function publisher()
{
    return $this->belongsTo(User::class, 'publisher_id');
}

public function reviews()
{
    return $this->hasMany(Review::class);
}


public function users()
{
    return $this->belongsToMany(User::class, 'library')->withPivot('status')->withTimestamps();
}

public function libraries()
{
    return $this->hasMany(\App\Models\Library::class);
}

}
