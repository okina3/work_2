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
                //ユーザー１のダミーデータ
                'user_id' => '1',
                'filename' => 'sample_1.jpg',
                'title' => null,
            ],
            [
                'user_id' => '1',
                'filename' => 'sample_2.jpg',
                'title' => null,
            ],

            //ユーザー２のダミーデータ
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

            //ユーザー３のダミーデータ
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

            //ユーザー１のダミーデータ（追加）
            [
                'user_id' => '1',
                'filename' => 'sample_7.jpg',
                'title' => null,
            ],
            [
                'user_id' => '1',
                'filename' => 'sample_8.jpg',
                'title' => null,
            ],
            [
                'user_id' => '1',
                'filename' => 'sample_9.jpg',
                'title' => null,
            ],
            [
                'user_id' => '1',
                'filename' => 'sample_10.jpg',
                'title' => null,
            ],
        ]);
    }
}
