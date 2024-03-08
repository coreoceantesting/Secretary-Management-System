<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tharav;
use App\Models\Department;

class AssignDepartmentToTharav extends Model
{
    use HasFactory;

    protected $fillable = ['tharav_id', 'department_id'];

    public function tharav()
    {
        return $this->belongsTo(Tharav::class, 'tharav_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
