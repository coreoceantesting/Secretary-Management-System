<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionSuplimentryAgenda extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'election_meeting_id', 'subject', 'file', 'is_meeting_completed'];

    public function electionscheduleMeeting()
    {
        return $this->belongsTo(ElectionScheduleMeeting::class, 'schedule_meeting_id', 'id');
    }

    public function electionMeeting()
    {
        return $this->belongsTo(ElectionMeeting::class, 'election_meeting_id', 'id');
    }
}
