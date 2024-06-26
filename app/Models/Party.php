<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Member;

class Party extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function members()
    {
        return $this->hasMany(Member::class, 'party_id', 'id');
    }
}
