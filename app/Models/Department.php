<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\PrastavSuchana;
use App\Models\Laxvadi;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'initial', 'is_home_department', 'deleted_at'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function prastavSuchana()
    {
        return $this->hasMany(PrastavSuchana::class);
    }

    public function laxvadi()
    {
        return $this->hasMany(Laxvadi::class);
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
