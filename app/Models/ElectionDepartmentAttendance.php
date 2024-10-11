<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionDepartmentAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'election_meeting_id', 'department_id', 'name', 'in_time', 'out_time'];
}
