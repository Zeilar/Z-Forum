<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableCategory extends Model
{
    public function tableSubcategories()
	{
		return $this->hasMany(TableSubcategory::class);
	}
}
