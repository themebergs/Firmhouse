<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    public function Category()
	{
		return $this->belongsTo(Category::class);
    }

    public function Expense()
    {
        return $this->hasMany(Expense::class);
    }

    public function Income()
    {
        return $this->hasMany(Income::class);
    }
}
