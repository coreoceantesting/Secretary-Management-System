<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\Department;

class Goshwara extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'meeting_id', 'file', 'remark', 'sent_by', 'date', 'is_sent'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}