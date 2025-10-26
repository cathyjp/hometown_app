<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // サンプル住民データを登録
        $residents = [
            [
                'family_name' => '佐藤',
                'first_name' => '健太',
                'family_name_kana' => 'サトウ',
                'first_name_kana' => 'ケンタ',
                'postal_code' => '1234567',
                'address_city' => '東京都渋谷区',
                'address_detail' => '神南1-2-3',
                'phone' => '09012345678',
                'gender' => 'M',
                'birth_date' => '198504',
                'email' => 'sato.kenta@example.com',
                'status' => '1',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'family_name' => '田中',
                'first_name' => '美咲',
                'family_name_kana' => 'タナカ',
                'first_name_kana' => 'ミサキ',
                'postal_code' => '2345678',
                'address_city' => '大阪府大阪市中央区',
                'address_detail' => '心斎橋筋2-1-5',
                'phone' => '09023456789',
                'gender' => 'F',
                'birth_date' => '199207',
                'email' => 'tanaka.misaki@example.com',
                'status' => '1',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'family_name' => '鈴木',
                'first_name' => '大輔',
                'family_name_kana' => 'スズキ',
                'first_name_kana' => 'ダイスケ',
                'postal_code' => '3456789',
                'address_city' => '福岡県福岡市博多区',
                'address_detail' => '博多駅前3-4-5',
                'phone' => '09034567890',
                'gender' => 'M',
                'birth_date' => '197811',
                'email' => 'suzuki.daisuke@example.com',
                'status' => '1',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'family_name' => '高橋',
                'first_name' => '愛',
                'family_name_kana' => 'タカハシ',
                'first_name_kana' => 'アイ',
                'postal_code' => '4567890',
                'address_city' => '北海道札幌市中央区',
                'address_detail' => '大通西5-6-7',
                'phone' => '09045678901',
                'gender' => 'F',
                'birth_date' => '199503',
                'email' => 'takahashi.ai@example.com',
                'status' => '1',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'family_name' => '伊藤',
                'first_name' => '誠',
                'family_name_kana' => 'イトウ',
                'first_name_kana' => 'マコト',
                'postal_code' => '5678901',
                'address_city' => '愛知県名古屋市中区',
                'address_detail' => '栄3-1-2',
                'phone' => '09056789012',
                'gender' => 'M',
                'birth_date' => '198309',
                'email' => 'ito.makoto@example.com',
                'status' => '1',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // 既存データがあれば無視して追加（重複を避ける）
        foreach ($residents as $resident) {
            DB::table('residents')->updateOrInsert(
                ['email' => $resident['email']],
                $resident
            );
        }
    }
}
