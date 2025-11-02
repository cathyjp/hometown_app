<?php

use function Livewire\Volt\{state, title};
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Reasons;
use App\Models\Residents;
use App\Models\ResidentReasons;

title('申請内容確認｜ふるさと住民登録');

// セッションからフォーム入力データを取得
$registerData = session('hometown_register', []);

// reasonのIDを取得
$reasonId = $registerData['reason'] ?? null;

// reasonのIDから該当するreasonのdescriptionを取得
$reasonDescription = null;
if ($reasonId) {
    $reason = Reasons::find($reasonId);
    $reasonDescription = $reason ? $reason->description : null;
}

state([
    'last_name' => $registerData['last_name'] ?? '',
    'first_name' => $registerData['first_name'] ?? '',
    'last_name_kana' => $registerData['last_name_kana'] ?? '',
    'first_name_kana' => $registerData['first_name_kana'] ?? '',
    'postal_code' => $registerData['postal_code'] ?? '',
    'prefecture' => $registerData['prefecture'] ?? '',
    'city' => $registerData['city'] ?? '',
    'address' => $registerData['address'] ?? '',
    'phone' => $registerData['phone'] ?? '',
    'gender' => $registerData['gender'] ?? '',
    'birth_year' => $registerData['birth_year'] ?? '',
    'birth_month' => $registerData['birth_month'] ?? '',
    'reason_description' => $reasonDescription, // 申請理由の説明文
]);

// 確認画面から登録完了画面へ
$submit = function () {
    // セッションからデータを取得
    $registerData = session('hometown_register', []);

    // genderを1文字に変換
    $genderMap = [
        '男性' => 'M',
        '女性' => 'F',
        '選択しない' => 'O',
    ];
    $gender = $genderMap[$registerData['gender']] ?? 'O';

    // birth_dateをYYMM形式に変換
    $birthYear = substr($registerData['birth_year'], -2);
    $birthMonth = str_pad($registerData['birth_month'], 2, '0', STR_PAD_LEFT);
    $birthDate = $birthYear . $birthMonth;

    // address_cityとaddress_detailを結合
    $addressCity = ($registerData['prefecture'] ?? '') . ($registerData['city'] ?? '');
    $addressDetail = $registerData['address'] ?? '';

    // トランザクション処理でResidentsとResidentReasonsの登録を行う
    DB::transaction(function () use ($registerData, $gender, $birthDate, $addressCity, $addressDetail) {
        // Residentsテーブルにデータを登録
        $resident = Residents::create([
            'family_name' => $registerData['last_name'],
            'first_name' => $registerData['first_name'],
            'family_name_kana' => $registerData['last_name_kana'],
            'first_name_kana' => $registerData['first_name_kana'],
            'postal_code' => $registerData['postal_code'],
            'address_city' => $addressCity,
            'address_detail' => $addressDetail,
            'phone' => $registerData['phone'],
            'gender' => $gender,
            'birth_date' => $birthDate,
            'email' => auth()->user()->email,
            'status' => '1',
            'is_deleted' => false,
        ]);

        // ResidentReasonsテーブルにデータを登録
        if (isset($registerData['reason']) && !empty($registerData['reason'])) {
            ResidentReasons::create([
                'resident_id' => $resident->id,
                'reason_id' => $registerData['reason'],
            ]);
        }
    });

    // セッションを保持したまま登録完了画面へリダイレクト
    return redirect()->route('hometown.register.complete');
};

// 入力画面に戻る
$back = function () {
    // セッションデータはそのまま保持されているので、
    // 入力フォーム画面でセッションデータを読み込めるようにフラグを設定
    session(['form_edit_mode' => true]);

    return redirect()->route('hometown.register.form');
};

?>

<div>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register-confirm.css') }}">

    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('hometown.about') }}">ふるさと住民制度</a> ＞
            <a href="{{ route('hometown.register.form') }}">登録情報入力</a> ＞
            <span>申請内容確認</span>
        </div>

        <div class="content-box">
            <h1 class="page-title">申請内容の確認</h1>

            <div class="confirm-description">
                <p>入力内容をご確認ください。問題がなければ「登録申請する」ボタンを押してください。</p>
            </div>

            <div class="confirm-section">
                <div class="confirm-row">
                    <div class="confirm-label">氏名</div>
                    <div class="confirm-value">{{ $last_name }} {{ $first_name }}</div>
                </div>
                <div class="confirm-row">
                    <div class="confirm-label">ふりがな</div>
                    <div class="confirm-value">{{ $last_name_kana }} {{ $first_name_kana }}</div>
                </div>
            </div>

            <div class="confirm-section">
                <div class="confirm-row">
                    <div class="confirm-label">郵便番号</div>
                    <div class="confirm-value">{{ $postal_code }}</div>
                </div>
                <div class="confirm-row">
                    <div class="confirm-label">住所</div>
                    <div class="confirm-value">
                        {{ $prefecture }}{{ $city }}
                        @if ($address)
                            {{ $address }}
                        @endif
                    </div>
                </div>
                <div class="confirm-row">
                    <div class="confirm-label">電話番号</div>
                    <div class="confirm-value">{{ $phone }}</div>
                </div>
            </div>

            <div class="confirm-section">
                <div class="confirm-row">
                    <div class="confirm-label">性別</div>
                    <div class="confirm-value">{{ $gender }}</div>
                </div>
                <div class="confirm-row">
                    <div class="confirm-label">生年月日(年・月)</div>
                    <div class="confirm-value">
                        @if ($birth_year && $birth_month)
                            {{ $birth_year }}年{{ $birth_month }}月
                        @endif
                    </div>
                </div>
            </div>

            @if ($reason_description)
                <div class="confirm-section">
                    <div class="confirm-row">
                        <div class="confirm-label">申請理由</div>
                        <div class="confirm-value">{{ $reason_description }}</div>
                    </div>
                </div>
            @endif

            <div class="btn-container">
                <button wire:click="back" class="btn btn-secondary">修正する</button>
                <button wire:click="submit" class="btn">登録申請する</button>
            </div>
        </div>
    </div>
</div>
