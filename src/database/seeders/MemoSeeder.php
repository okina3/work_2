<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemoSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        DB::table('memos')->insert([
            [
                'content' => 'ユーザー１・・・・・テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１',
                'user_id' => '1',
                'image1' => '1',
                'image2' => '2',
                'created_at' => '2023/010/01/ 11:11:11'
            ],
            [
                'content' => 'ユーザー１・・・・・テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２',
                'user_id' => '1',
                'image1' => '1',
                'image2' => '1',
                'created_at' => '2023/010/01/ 11:11:11'
            ],
            [
                'content' => 'ユーザー１・・・・・テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３',
                'user_id' => '1',
                'image1' => '2',
                'image2' => '2',
                'created_at' => '2023/010/01/ 11:11:11'
            ],

            [
                'content' => 'ユーザー２・・・・・テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１',
                'user_id' => '2',
                'image1' => '3',
                'image2' => '4',
                'created_at' => '2023/010/02/ 11:11:11'
            ],
            [
                'content' => 'ユーザー２・・・・・テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２',
                'user_id' => '2',
                'image1' => '3',
                'image2' => '3',
                'created_at' => '2023/010/02/ 11:11:11'
            ],
            [
                'content' => 'ユーザー２・・・・・テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３',
                'user_id' => '2',
                'image1' => '4',
                'image2' => '4',
                'created_at' => '2023/010/02/ 11:11:11'
            ],

            [
                'content' => 'ユーザー３・・・・・テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１、テスト１',
                'user_id' => '3',
                'image1' => '5',
                'image2' => '6',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
            [
                'content' => 'ユーザー３・・・・・テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２、テスト２',
                'user_id' => '3',
                'image1' => '5',
                'image2' => '5',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
            [
                'content' => 'ユーザー３・・・・・テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３、テスト３',
                'user_id' => '3',
                'image1' => '6',
                'image2' => '6',
                'created_at' => '2023/010/03/ 11:11:11'
            ],
        ]);
    }
}
