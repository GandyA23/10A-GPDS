<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'last_name', 'email', 'salary' ,'job_title'];
    protected $hidden = ['id'];

    private const TAX_PERCENTAGE = 0.84;   // 16%

    public static function setCategory($salary) : string
    {
        if ($salary < 7000)
            return 'A';
        else if ($salary < 12000)
            return 'B';
        return 'C';
    }

    public static function calulateSalaryTaxes($salary) : float
    {
        return $salary * self::TAX_PERCENTAGE;
    }
}
