<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionAssignMemberToMeeting extends Model
{
    use HasFactory;

    protected $fillable = ['election_meeting_id', 'member_id'];

    public function electionMeeting()
    {
        return $this->belongsTo(ElectionMeeting::class, 'election_meeting_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
