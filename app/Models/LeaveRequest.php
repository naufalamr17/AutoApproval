<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nik',
        'position',
        'start_date',
        'end_date',
        'destination_place',
        'activity_purpose',
    ];
}
