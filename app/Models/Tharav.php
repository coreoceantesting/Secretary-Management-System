<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\ScheduleMeeting;
use App\Models\AssignDepartmentToTharav;

class Tharav extends Model
{
    use HasFactory;

    protected $fillable = ['meeting_id', 'schedule_meeting_id', 'date', 'time', 'datetime', 'file', 'remark'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function scheduleMeeting()
    {
        return $this->belongsTo(ScheduleMeeting::class, 'schedule_meeting_id', 'id');
    }

    public function assignTharavDepartment()
    {
        return $this->hasMany(AssignDepartmentToTharav::class, 'tharav_id', 'id');
    }

    public function tharavQuestions()
    {
        return $this->hasMany(TharavQuestion::class, 'tharav_id', 'id');
    }
}
