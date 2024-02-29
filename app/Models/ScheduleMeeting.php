<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;

class ScheduleMeeting extends Model
{
    use HasFactory;

    protected $fillable = ['meeting_id', 'place', 'date', 'time', 'file', 'datetime'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
