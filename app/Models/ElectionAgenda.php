<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionAgenda extends Model
{
    use HasFactory;

    protected $fillable = ['meeting_id', 'subject', 'file', 'date', 'time', 'place', 'is_meeting_schedule'];

    public function meeting()
    {
        return $this->belongsTo(ElectionMeeting::class, 'meeting_id', 'id');
    }
}
