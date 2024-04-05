<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['meeting_id', 'from_date', 'to_date', 'prefix', 'sequence', 'status'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
