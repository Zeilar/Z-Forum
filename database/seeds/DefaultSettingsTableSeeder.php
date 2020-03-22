<?php

use Illuminate\Database\Seeder;
use App\DefaultSettings;

class DefaultSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultSettings::create([
			'settings' => '{
				"posts_per_page": 5
			}',
		]);
    }
}