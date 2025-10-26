<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResidentReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 住民データを取得
        $residents = DB::table('residents')->get();

        // 理由データを取得
        $reasons = DB::table('reasons')->get();

        // reasonsが空の場合は処理をスキップ
        if ($reasons->isEmpty()) {
            echo "理由データが存在しません。ReasonSeederを先に実行してください。\n";
            return;
        }

        // 各住民に対して1つの理由をランダムに割り当てる
        foreach ($residents as $resident) {
            // ランダムに理由を選択
            $randomReason = $reasons->random();

            // 既に関連付けがあるか確認
            $exists = DB::table('resident_reasons')
                ->where('resident_id', $resident->id)
                ->where('reason_id', $randomReason->id)
                ->exists();

            // 関連付けがなければ作成
            if (!$exists) {
                DB::table('resident_reasons')->insert([
                    'resident_id' => $resident->id,
                    'reason_id' => $randomReason->id,
                ]);
            }
        }
    }
}
