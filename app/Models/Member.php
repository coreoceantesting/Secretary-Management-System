<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Ward;
use App\Models\Attendance;
use App\Models\Party;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['ward_id', 'name', 'contact_number', 'email', 'party_id', 'address', 'designation', 'deleted_at', 'photo', 'alternate_number'];

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id', 'id');
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class, 'member_id', 'id');
    }

    public static function booted()
    {
        static::created(function (self $user) {
            if (Auth::check()) {
                self::where('id', $user->id)->update([
                    'created_by' => Auth::user()->id,
                ]);
            }
        });
        static::updated(function (self $user) {
            if (Auth::check()) {
                self::where('id', $user->id)->update([
                    'updated_by' => Auth::user()->id,
                ]);
            }
        });
        static::deleting(function (self $user) {
            if (Auth::check()) {
                self::where('id', $user->id)->update([
                    'deleted_by' => Auth::user()->id,
                ]);
            }
        });
    }
}
