<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public static $rules = [
        'name' => ['required', 'max:45', 'min:2'],
        'first_surname' => ['required', 'max:45', 'min:2'],
        'second_surname' => ['nullable', 'max:45', 'min:2'],
    ];

    protected $fillable = [
        'name',
        'first_surname',
        'second_surname',
    ];

    public $timestamps = false;

    /**
     * The books that belong to the author.
     */
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
