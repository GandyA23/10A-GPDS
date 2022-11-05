<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static $rules = [
        'title' => ['required', 'max:255'],
        'isbn' => ['required', 'max:15', 'unique:books,isbn'],
        'category_id' => ['required', 'exists:categories,id'],
        'editorial_id' => ['required', 'exists:editorials,id'],
        'authors' => ['sometimes', 'array', 'exists:authors,id'],
    ];

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
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * The category that belongs to the book
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The editorial that belongs to the book
     */
    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    /**
     * The book has a book's download counter
     */
    public function bookDownload()
    {
        return $this->hasOne(BookDownload::class);
    }
}
