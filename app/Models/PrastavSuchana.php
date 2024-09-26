<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\ScheduleMeeting;
use App\Models\PrastavSuchanaSubQuestion;

class PrastavSuchana extends Model
{
    use HasFactory;

    protected $fillable = ['meeting_id', 'schedule_meeting_id', 'question_file', 'response_file', 'department_id'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function scheduleMeeting()
    {
        return $this->belongsTo(ScheduleMeeting::class, 'schedule_meeting_id', 'id');
    }

    public function parentScheduleMeeting()
    {
        return $this->belongsTo(ScheduleMeeting::class, 'schedule_meeting_id', 'id')->latestOfMany();
    }

    public function prastavSuchanaSubQuestion()
    {
        return $this->hasMany(PrastavSuchanaSubQuestion::class, 'prastav_suchana_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
