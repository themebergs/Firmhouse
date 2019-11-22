<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    public function SubCategory()
	{
		return $this->belongsTo(SubCategory::class);
    }
}
