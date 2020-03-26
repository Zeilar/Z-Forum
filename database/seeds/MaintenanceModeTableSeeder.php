<?php

use Illuminate\Database\Seeder;
use App\MaintenanceMode;

class MaintenanceModeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaintenanceMode::create([
			'enabled' => false,
		]);
    }
}