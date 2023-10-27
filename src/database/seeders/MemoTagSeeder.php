<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemoTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('memo_tags')->insert([
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

            [
                'memo_id' => '4',
                'tag_id' => '5',
            ],
            [
                'memo_id' => '5',
                'tag_id' => '5',
            ],
            [
                'memo_id' => '6',
                'tag_id' => '6',
            ],

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
        ]);
    }
}
