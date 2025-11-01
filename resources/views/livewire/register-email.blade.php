<?php

use function Livewire\Volt\{state, title, mount};
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

title('ふるさと住民登録申請フォーム｜平泉町');

state([
    'email' => '',
    'password' => '',
    'name' => 'ふるさと住民',
    'error' => '',
    'success' => false,
]);

$submit = function () {
    // デバッグ・テスト用: メールアドレスが"test"の場合は成功画面を表示してから10秒後にregister-formに遷移
    if ($this->email === 'test') {
        // テストデータをセッションに保存
        Session::put('hometown_register', [
            'last_name' => '山田',
            'first_name' => '太郎',
            'last_name_kana' => 'やまだ',
            'first_name_kana' => 'たろう',
            'postal_code' => '1234567',
            'prefecture' => '北海道',
            'city' => '札幌市白石区1-1',
            'address' => '平泉マンション101号室',
            'phone' => '09012345678',
            'gender' => '男性',
            'birth_year' => '1992',
            'birth_month' => '1',
        ]);

        // 成功画面を表示（10秒後にJavaScriptでリダイレクト）
        $this->success = true;
        return;
    }

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
                <div class="success-message" data-email="{{ $email }}">
                    <p>メールアドレスの確認メールを送信しました。</p>
                    <p>メールに記載されたリンクをクリックして、メールアドレスの確認を完了してください。</p>
                    <div class="btn-container">
                        <a href="{{ route('verification.notice') }}" class="btn">確認メールの再送信</a>
                    </div>
                </div>
            @else
                <form wire:submit="submit" class="email-form" id="email-form" novalidate>
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

            <script>
                // デバッグ・テスト用: "test"の場合はブラウザ側のバリデーションを無効化
                document.addEventListener('DOMContentLoaded', function() {
                    const emailInput = document.getElementById('email');
                    const emailForm = document.getElementById('email-form');

                    if (emailInput && emailForm) {
                        emailInput.addEventListener('input', function() {
                            if (this.value === 'test') {
                                this.type = 'text';
                                emailForm.setAttribute('novalidate', 'novalidate');
                            } else {
                                this.type = 'email';
                            }
                        });

                        emailForm.addEventListener('submit', function(e) {
                            const emailValue = emailInput.value;
                            if (emailValue === 'test') {
                                // "test"の場合はブラウザ側のバリデーションをスキップ
                                e.preventDefault();
                                @this.call('submit');
                            }
                        });
                    }
                });

                // デバッグ・テスト用: success=trueかつemail=testの場合、10秒後にregister-formにリダイレクト
                function checkTestRedirect() {
                    const successMessage = document.querySelector('.success-message');
                    if (successMessage) {
                        const emailValue = successMessage.getAttribute('data-email');
                        if (emailValue === 'test') {
                            // 既にタイマーが設定されている場合はスキップ
                            if (successMessage.dataset.timerSet === 'true') {
                                return;
                            }
                            successMessage.dataset.timerSet = 'true';

                            // 10秒後にregister-formにリダイレクト
                            setTimeout(function() {
                                window.location.href = '{{ route('hometown.register.form') }}';
                            }, 10000);
                        }
                    }
                }

                // Livewireの更新を監視
                document.addEventListener('livewire:init', function() {
                    Livewire.hook('morph.updated', function() {
                        checkTestRedirect();
                    });
                });

                // DOMContentLoadedでも確認
                document.addEventListener('DOMContentLoaded', function() {
                    checkTestRedirect();
                });
            </script>
        </div>
    </div>
</div>
