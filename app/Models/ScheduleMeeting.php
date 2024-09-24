<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\Agenda;
use App\Models\SuplimentryAgenda;
use App\Models\AssignScheduleMeetingDepartment;
use App\Models\Question;
use App\Models\ProceedingRecord;
use App\Models\Tharav;

class ScheduleMeeting extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'agenda_id', 'meeting_id', 'place', 'date', 'time', 'file', 'reschedule_reason', 'datetime', 'is_meeting_reschedule', 'is_meeting_completed', 'parent_id', 'unique_id'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id', 'id');
    }

    public function suplimentryAgenda()
    {
        return $this->hasMany(SuplimentryAgenda::class, 'schedule_meeting_id', 'id');
    }

    public function assignScheduleMeetingDepartment()
    {
        return $this->hasMany(AssignScheduleMeetingDepartment::class, 'schedule_meeting_id', 'id');
    }

    public function parentLatestScheduleMeeting()
    {
        return $this->hasOne(ScheduleMeeting::class, 'parent_id', 'id');
    }

    public function parentLatestScheduleMeetings()
    {
        return $this->belongsTo(ScheduleMeeting::class, 'parent_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'schedule_meeting_id', 'id');
    }

    public function proceedingRecord()
    {
        return $this->hasOne(ProceedingRecord::class, 'schedule_meeting_id', 'id');
    }

    public function tharav()
    {
        return $this->hasOne(Tharav::class, 'schedule_meeting_id', 'id');
    }
}
