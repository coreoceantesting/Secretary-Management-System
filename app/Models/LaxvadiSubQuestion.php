<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Laxvadi;

class LaxvadiSubQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['laxvadi_id', 'question', 'member_id', 'response', 'is_mayor_selected', 'is_sended'];

    public function laxvadi()
    {
        return $this->belongsTo(Laxvadi::class, 'laxvadi_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
