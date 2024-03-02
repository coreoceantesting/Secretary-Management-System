<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ScheduleMeeting;

class SuplimentryAgenda extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'name', 'file', 'is_meeting_completed'];

    public function scheduleMeeting()
    {
        return $this->belongsTo(ScheduleMeeting::class, 'schedule_meeting_id', 'id');
    }
}
