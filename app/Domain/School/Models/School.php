<?php

namespace App\Domain\School\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        // tambahkan field di sini
        'name',
        'address',
    ];
}
