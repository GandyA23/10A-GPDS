<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'description',
        'published_date',
        'category_id',
        'editorial_id',
    ];

    public $timestamps = false;

    /**
     * The authors that belong to the book.
     */
    public function authors() {
        return $this->belongsToMany(Author::class);
    }

    /**
     * The category that belongs to the book
     */
    public function category() {
        return $this->belongsTo(Category::class);
    }
}
