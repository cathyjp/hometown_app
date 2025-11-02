<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // サンプルデータを登録
        $reasons = [
            [
                'name' => '出身者',
                'description' => '平泉町出身である',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '家族・親戚',
                'description' => '家族または親戚が平泉町に住んでいる、または住んでいた',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '寄付者',
                'description' => '平泉町にふるさと応援寄附金を行った',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '固定資産所有者',
                'description' => '町内に固定資産を有している',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '通勤・通学者',
                'description' => '平泉町に通勤または通学している、またはしていた',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '団体所属者',
                'description' => '平泉町出身者等で構成するふるさと会等の団体に所属している',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => '事業参加者',
                'description' => '平泉町内で起業および町内企業への就職を促進する事業を終了した',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // 既存データがあれば無視して追加（重複を避ける）
        foreach ($reasons as $reason) {
            DB::table('reasons')->updateOrInsert(
                ['name' => $reason['name']],
                $reason
            );
        }
    }
}
