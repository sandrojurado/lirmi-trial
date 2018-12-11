<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$date = Carbon::now();
    	for ($i = 0; $i <= 30; $i++)
		{
			DB::table('classes')->insert([
				'class_date' => date_add($date, date_interval_create_from_date_string((2) . ' days'))
			]);
		}

    }
}
