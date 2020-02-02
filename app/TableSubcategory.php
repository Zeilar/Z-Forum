<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableSubcategory extends Model
{
    public function tableCategory()
	{
		return $this->belongsTo(TableCategory::class);
	}
}
