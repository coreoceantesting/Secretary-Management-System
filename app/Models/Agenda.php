<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssignGoshwaraToAgenda;
use App\Models\ScheduleMeeting;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['is_meeting_schedule', 'meeting_id', 'subject', 'file', 'pdf', 'date', 'time', 'place', 'is_mayor_finalised'];

    public function assignGoshwaraToAgenda()
    {
        return $this->hasMany(AssignGoshwaraToAgenda::class, 'agenda_id', 'id');
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function scheduleMeeting()
    {
        return $this->hasMany(ScheduleMeeting::class, 'agenda_id', 'id');
    }

    public function latestScheduleMeeting()
    {
        return $this->hasOne(ScheduleMeeting::class, 'agenda_id', 'id')->latest();
    }
}
