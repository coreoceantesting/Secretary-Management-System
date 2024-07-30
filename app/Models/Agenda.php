<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssignGoshwaraToAgenda;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['is_meeting_schedule', 'meeting_id', 'name', 'file', 'date', 'time', 'place'];

    public function assignGoshwaraToAgenda()
    {
        return $this->hasMany(AssignGoshwaraToAgenda::class, 'agenda_id', 'id');
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
