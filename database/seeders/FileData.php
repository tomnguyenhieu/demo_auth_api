<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FileData extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		for ($i = 0; $i < 10; $i++) {
			DB::table('files')->insert([
				'name' => 'Filename_' . $i + 1,
				'user_id' => 3,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);
		}
	}
}
