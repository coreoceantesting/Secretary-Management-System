<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'meeting_id', 'member_id', 'in_time', 'out_time'];
}
