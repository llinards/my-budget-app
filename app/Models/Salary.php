<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'isMainSalary',
        'amount'
    ];

    public function scopeMainSalary($query)
    {
        return $query->where('isMainSalary', true)->latest('created_at')->first();
    }
}
