<?php

use function Livewire\Volt\{state, title};
use Illuminate\Support\Facades\Session;
use App\Models\Reasons;

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

    // ここで実際のデータベース登録処理を行う
    // 例: Residentモデルに保存するなど
    // 今回はサンプルのため省略

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
            <a href="{{ route('hometown.about') }}">ふるさと住民制度</a> &gt;
            <a href="{{ route('hometown.register.form') }}">登録情報入力</a> &gt;
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
                    <div class="confirm-label">生年月日</div>
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
