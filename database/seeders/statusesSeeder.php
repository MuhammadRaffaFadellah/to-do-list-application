<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class statusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            [
                'name'  => 'Expired',
            ],
            [
                'name'  => 'In Progress',
            ],
            [
                'name'  => 'Completed',
            ],
        ]);
    }
}
