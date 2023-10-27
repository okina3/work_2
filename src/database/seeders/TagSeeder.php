<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            [
                'name' => 'タグ１(ユ１)',
                'user_id' => '1',
                'created_at' => '2023/010/01/ 11:11:11'
            ],
            [
                'name' => 'タグ２(ユ１)',
                'user_id' => '1',
                'created_at' => '2023/010/01/ 11:11:11'
            ],
            [
                'name' => 'タグ３(ユ１)',
                'user_id' => '1',
                'created_at' => '2023/010/02/ 11:11:11'
            ],

            [
                'name' => 'タグ１(ユ２)',
                'user_id' => '2',
                'created_at' => '2023/010/02/ 11:11:11'
            ],
            [
                'name' => 'タグ２(ユ２)',
                'user_id' => '2',
                'created_at' => '2023/010/02/ 11:11:11'
            ],
            [
                'name' => 'タグ３(ユ２)',
                'user_id' => '2',
                'created_at' => '2023/010/02/ 11:11:11'
            ],

            [
                'name' => 'タグ１(ユ３)',
                'user_id' => '3',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
            [
                'name' => 'タグ２(ユ３)',
                'user_id' => '3',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
            [
                'name' => 'タグ３(ユ３)',
                'user_id' => '3',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
        ]);
    }
}
