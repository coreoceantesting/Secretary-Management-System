<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TharavQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['tharav_id', 'department_id', 'question', 'question_by', 'question_time', 'answer', 'answer_by', 'answer_time'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function tharav()
    {
        return $this->belongsTo(Tharav::class, 'tharav_id', 'id');
    }
}
