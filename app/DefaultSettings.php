<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultSettings extends Model
{
	public $timestamps = false;

	/**
     * The default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'settings' => '{
			"posts_per_page": 20
		}'
    ];
}