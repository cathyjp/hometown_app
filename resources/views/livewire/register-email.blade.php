<?php

use function Livewire\Volt\{state, title, mount};
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Password;

title('ふるさと住民登録申請フォーム｜平泉町');

state([
    'email' => '',
    'password' => '',
    'name' => 'ふるさと住民',
    'error' => '',
    'success' => false,
]);

$submit = function () {
    $this->validate(
        [
            'email' => 'required|email|unique:users',
        ],
        [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '有効なメールアドレスを入力してください',
            'email.unique' => 'このメールアドレスは既に登録されています',
        ],
    );

    // ランダムなパスワードを生成
    $this->password = \Illuminate\Support\Str::random(16);

    // ユーザー登録
    $user = User::create([
        'name' => $this->name,
        'email' => $this->email,
        'password' => Hash::make($this->password),
    ]);

    // 登録イベントを発火（メール認証用）
    event(new Registered($user));

    // 自動ログイン
    Auth::login($user);

    // 成功メッセージを表示
    $this->success = true;
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

            @if ($success)
                <div class="success-message">
                    <p>メールアドレスの確認メールを送信しました。</p>
                    <p>メールに記載されたリンクをクリックして、メールアドレスの確認を完了してください。</p>
                    <div class="btn-container">
                        <a href="{{ route('verification.notice') }}" class="btn">確認メールの再送信</a>
                    </div>
                </div>
            @else
                <form wire:submit="submit" class="email-form">
                    <div class="form-group">
                        <label for="email" class="form-label no-icon">メールアドレス</label>
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
            @endif
        </div>
    </div>
</div>
