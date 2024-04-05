<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssignGoshwaraToAgenda;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['is_meeting_schedule', 'name', 'file'];

    public function assignGoshwaraToAgenda()
    {
        return $this->hasMany(AssignGoshwaraToAgenda::class, 'agenda_id', 'id');
    }
}
