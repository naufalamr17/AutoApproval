<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'name',
        'nik',
        'region',
        'position',
        'start_date',
        'end_date',
        'destination_place',
        'activity_purpose',
        'status',
    ];
}