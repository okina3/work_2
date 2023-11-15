<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
            [
                'user_id' => '1',
                'filename' => 'sample_1.jpg',
                'title' => null,
            ],
            [
                'user_id' => '1',
                'filename' => 'sample_2.jpg',
                'title' => null,
            ],
            [
                'user_id' => '2',
                'filename' => 'sample_3.jpg',
                'title' => null,
            ],
            [
                'user_id' => '2',
                'filename' => 'sample_4.jpg',
                'title' => null,
            ],
            [
                'user_id' => '3',
                'filename' => 'sample_5.jpg',
                'title' => null,
            ],
            [
                'user_id' => '3',
                'filename' => 'sample_6.jpg',
                'title' => null,
            ],
        ]);
    }
}
