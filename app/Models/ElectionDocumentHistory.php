<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElectionDocumentHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['upload_file', 'subject', 'created_by', 'deleted_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
