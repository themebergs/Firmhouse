<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    public function User()
    {
    return $this->belongsTo(User::class);
    }
}
