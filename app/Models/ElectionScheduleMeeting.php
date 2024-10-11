<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionScheduleMeeting extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'election_agenda_id', 'election_meeting_id', 'unique_id', 'election_schedule_meeting_id', 'date', 'time', 'place', 'reschedule_reason', 'datetime', 'is_meeting_reschedule', 'is_meeting_completed', 'is_meeting_cancel', 'cancel_remark', 'meeting_end_date', 'meeting_end_time', 'meeting_end_reason', 'is_record_proceeding'];

    public function electionAgenda()
    {
        return $this->belongsTo(ElectionAgenda::class, 'election_agenda_id', 'id');
    }

    public function electionMeeting()
    {
        return $this->belongsTo(ElectionMeeting::class, 'election_meeting_id', 'id');
    }

    public function assignScheduleMeetingDepartment()
    {
        return $this->hasMany(ElectionAssignScheduleMeetingDepartment::class, 'election_schedule_meeting_id', 'id');
    }
}
