<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

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
