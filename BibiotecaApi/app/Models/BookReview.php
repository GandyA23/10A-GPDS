<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'book_id',
    ];

    public static $rules = [
        'comment' => ['required', 'max:255'],
        'book_id' => ['nullable', 'exists:books,id'],
    ];

    public $timestamps = false;

    /**
     * The book that belongs to the review.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * The user that belongs to the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
