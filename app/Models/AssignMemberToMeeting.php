<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\Member;

class AssignMemberToMeeting extends Model
{
    use HasFactory;

    protected $fillable = ['meeting_id', 'member_id'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
