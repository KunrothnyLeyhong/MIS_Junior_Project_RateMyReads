<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    // use HasFactory;
    protected $table = 'library';

    protected $fillable = ['user_id', 'book_id', 'status'];

    public function book()
{
    return $this->belongsTo(\App\Models\Book::class);
}

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
