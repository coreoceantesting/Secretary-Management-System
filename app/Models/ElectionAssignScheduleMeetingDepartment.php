<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionAssignScheduleMeetingDepartment extends Model
{
    use HasFactory;

    protected $fillable = ['election_schedule_meeting_id', 'department_id'];

    public function electionScheduleMeeting()
    {
        return $this->belongsTo(ElectionScheduleMeeting::class, 'election_schedule_meeting_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
