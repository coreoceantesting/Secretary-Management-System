<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserElectionMeeting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'election_meeting_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function meeting()
    {
        return $this->belongsTo(ElectionMeeting::class, 'election_meeting_id', 'id');
    }
}
