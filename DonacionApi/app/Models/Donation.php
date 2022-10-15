<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = ['amount'];

    public static function makeReference (): string {
        $random = rand(10000, 99999);
        $timestamp = Carbon::now()->timestamp;
        return "REF$random$timestamp";
    }
}
