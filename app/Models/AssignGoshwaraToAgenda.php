<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agenda;
use App\Models\Goshwara;

class AssignGoshwaraToAgenda extends Model
{
    use HasFactory;

    protected $fillable = ['agenda_id', 'goshwara_id'];

    public function goshwara()
    {
        return $this->belongsTo(Goshwara::class, 'goshwara_id', 'id');
    }

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id', 'id');
    }
}
