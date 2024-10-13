<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['election_schedule_meeting_id', 'election_meeting_id', 'member_id', 'in_time', 'out_time'];

    public function electionScheduleMeeting()
    {
        return $this->belongsTo(ElectionScheduleMeeting::class, 'election_schedule_meeting_id', 'id');
    }

    public function electionMeeting()
    {
        return $this->belongsTo(ElectionMeeting::class, 'election_meeting_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
