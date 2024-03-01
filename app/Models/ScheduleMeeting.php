<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\Agenda;

class ScheduleMeeting extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'agenda_id', 'meeting_id', 'place', 'date', 'time', 'file', 'datetime', 'is_meeting_reschedule', 'is_meeting_completed'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id', 'id');
    }
}
