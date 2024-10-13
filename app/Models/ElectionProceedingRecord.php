<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionProceedingRecord extends Model
{
    use HasFactory;

    protected $fillable = ['election_meeting_id', 'election_schedule_meeting_id', 'date', 'time', 'datetime', 'file', 'remark'];

    public function electionMeeting(){
        return $this->belongsTo(ElectionMeeting::class, 'election_meeting_id', 'id');
    }

    public function electionScheduleMeeting(){
        return $this->belongsTo(ElectionScheduleMeeting::class, 'election_schedule_meeting_id', 'id');
    }
}
