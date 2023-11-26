<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemoTagSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        DB::table('memo_tags')->insert([
            //ユーザー１のダミーデータ
            [
                'memo_id' => '1',
                'tag_id' => '1',
            ],
            [
                'memo_id' => '2',
                'tag_id' => '2',
            ],
            [
                'memo_id' => '3',
                'tag_id' => '3',
            ],

            //ユーザー２のダミーデータ
            [
                'memo_id' => '4',
                'tag_id' => '4',
            ],
            [
                'memo_id' => '5',
                'tag_id' => '5',
            ],
            [
                'memo_id' => '6',
                'tag_id' => '6',
            ],

            //ユーザー３のダミーデータ
            [
                'memo_id' => '7',
                'tag_id' => '7',
            ],
            [
                'memo_id' => '8',
                'tag_id' => '8',
            ],
            [
                'memo_id' => '9',
                'tag_id' => '9',
            ],

            //ユーザー１のダミーデータ（追加）
            [
                'memo_id' => '10',
                'tag_id' => '10',
            ],
            [
                'memo_id' => '11',
                'tag_id' => '11',
            ],
            [
                'memo_id' => '12',
                'tag_id' => '12',
            ],
            [
                'memo_id' => '13',
                'tag_id' => '13',
            ],
        ]);
    }
}
