<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ScheduleMeeting;
use App\Models\Meeting;
use App\Models\Department;

class DepartmentAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'meeting_id', 'department_id', 'name', 'in_time', 'out_time'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function scheduleMeeting()
    {
        return $this->belongsTo(ScheduleMeeting::class, 'schedule_meeting_id', 'id');
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
