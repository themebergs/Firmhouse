<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function Sector()
	{
		return $this->belongsTo(Sector::class);
    }
    
    public function SubCategory()
    {
        return $this->hasMany(SubCategory::class);
    }
}
