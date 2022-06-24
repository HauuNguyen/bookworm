<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'book';
    public function bookReview()
    {
        return $this->hasMany(Review::class);
    }
    public function bookCategory(){
        return $this->belongsTo(Category::class);
    }
    public function bookDiscount(){
        return $this->hasMany(Discount::class);
    }
    public function author(){
        return $this->belongsTo(Author::class);
    }
}
