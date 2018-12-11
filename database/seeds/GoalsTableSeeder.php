<?php

use Illuminate\Database\Seeder;

class GoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('goals')->insert([
			'name' => 'OA 1',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 2',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 3',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 4',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 5',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 6',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 7',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 8',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 9',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
		DB::table('goals')->insert([
			'name' => 'OA 10',
			'goal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'color' => '#' . dechex(rand(0x000000, 0xFFFFFF)),
		]);
    }
}
