<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ScheduleMeeting;
use App\Models\Meeting;
use App\Models\Member;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_meeting_id', 'meeting_id', 'member_id', 'in_time', 'out_time'];

    public function scheduleMeeting()
    {
        return $this->belongsTo(ScheduleMeeting::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
