<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrastavSuchanaSubQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['prastav_suchana_id', 'question', 'member_id', 'response', 'is_mayor_selected', 'is_sended'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
