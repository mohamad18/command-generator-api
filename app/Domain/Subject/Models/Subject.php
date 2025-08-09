<?php

namespace App\Domain\Subject\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        // tambahkan field di sini
        'school_id',
        'name',
        'description',
    ];
}
