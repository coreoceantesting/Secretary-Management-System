<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class SubQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'question', 'member_id', 'response', 'is_mayor_selected', 'is_sended', 'is_mayor_selected_datetime', 'response_datetime'];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
