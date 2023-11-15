<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            [
                'name' => 'タグ１(ユ1)',
                'user_id' => '1',
                'created_at' => '2023/010/01/ 11:11:11'
            ],
            [
                'name' => 'タグ２(ユ1)',
                'user_id' => '1',
                'created_at' => '2023/010/01/ 11:11:11'
            ],
            [
                'name' => 'タグ３(ユ1)',
                'user_id' => '1',
                'created_at' => '2023/010/02/ 11:11:11'
            ],

            [
                'name' => 'タグ１(ユ2)',
                'user_id' => '2',
                'created_at' => '2023/010/02/ 11:11:11'
            ],
            [
                'name' => 'タグ２(ユ2)',
                'user_id' => '2',
                'created_at' => '2023/010/02/ 11:11:11'
            ],
            [
                'name' => 'タグ３(ユ2)',
                'user_id' => '2',
                'created_at' => '2023/010/02/ 11:11:11'
            ],

            [
                'name' => 'タグ１(ユ3)',
                'user_id' => '3',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
            [
                'name' => 'タグ２(ユ3)',
                'user_id' => '3',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
            [
                'name' => 'タグ３(ユ3)',
                'user_id' => '3',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
        ]);
    }
}
