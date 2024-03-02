<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ScheduleMeeting;
use App\Models\Department;

class AssignScheduleMeetingDepartment extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'department_id'];

    public function scheduleMeeting()
    {
        return $this->belongsTo(ScheduleMeeting::class, 'schedule_meeting_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
