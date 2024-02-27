<?php

namespace App\Repository;

use App\Models\Ward;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommonRepository
{
    public function getWardMember()
    {
        return Ward::with(['members'])->get();
    }
}