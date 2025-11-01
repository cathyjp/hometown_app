<?php

use function Livewire\Volt\{state, title};

title('メールアドレス入力｜ふるさと住民登録');

state([
    'email' => '',
    'error' => '',
]);

$submit = function () {
    $this->validate(
        [
            'email' => 'required|email',
        ],
        [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '有効なメールアドレスを入力してください',
        ],
    );

    // メール送信処理（実際の実装はここに記述）
    // 成功したら次の画面にリダイレクト
    return redirect()->route('hometown.register.form');
};

?>

<div>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register-email.css') }}">

    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('hometown.about') }}">ふるさと住民制度</a> &gt;
            <span>メールアドレス入力</span>
        </div>

        <div class="content-box">
            <h1 class="page-title">ふるさと住民登録申請フォーム</h1>

            <div class="form-description">
                <p>ご本人確認のため、こちらよりメールアドレスをご入力いただき、送信してください。</p>
            </div>

            <form wire:submit="submit" class="email-form">
                <div class="form-group">
                    <label for="email" class="form-label">メールアドレス</label>
                    <input type="email" id="email" wire:model="email" class="form-input"
                        placeholder="例：example@example.com">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn">承認メールを送信</button>
                </div>
            </form>
        </div>
    </div>
</div>
