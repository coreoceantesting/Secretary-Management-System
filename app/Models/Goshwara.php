<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meeting;
use App\Models\Department;
use App\Models\User;
use App\Models\AssignGoshwaraToAgenda;

class Goshwara extends Model
{
    use HasFactory;

    protected $fillable = ['outward_no', 'department_id', 'meeting_id', 'file', 'subject', 'sent_by', 'date', 'is_sent', 'is_mayor_selected', 'sub_subject', 'selected_datetime', 'selected_by'];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by', 'id');
    }

    public function assignGoshwaraToAgenda()
    {
        return $this->hasMany(AssignGoshwaraToAgenda::class, 'goshwara_id', 'id');
    }
}
