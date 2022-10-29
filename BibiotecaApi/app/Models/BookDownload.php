<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDownload extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'total_downloads',
        'book_id',
    ];

    /**
     * The book's downloads that belongs to the book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
