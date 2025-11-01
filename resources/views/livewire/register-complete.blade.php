<?php

use function Livewire\Volt\{title};

title('申請完了｜ふるさと住民登録');

?>

<div>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register-complete.css') }}">

    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('hometown.about') }}">ふるさと住民制度</a> &gt;
            <span>申請完了</span>
        </div>

        <div class="content-box">
            <div class="complete-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>

            <h1 class="page-title">ふるさと住民登録申請が完了しました</h1>

            <div class="complete-message">
                <p>ふるさと住民登録申請を受け付けました。<br>
                    ご登録いただいたメールアドレスに確認メールをお送りしましたので、ご確認ください。<br>
                    申請内容を確認後、ふるさと住民票カードを発行いたします。<br>
                    発行までに1〜2週間ほどお時間をいただきます。</p>
            </div>

            <div class="notice-box">
                <h2 class="notice-title">今後のお手続きについて</h2>
                <p>ふるさと住民票カードの発行が完了しましたら、ご登録いただいたメールアドレスにお知らせいたします。<br>
                    その後、ご登録いただいた住所に郵送にてお届けいたします。</p>
            </div>

            <div class="btn-container">
                <a href="{{ route('hometown.about') }}" class="btn">トップページに戻る</a>
            </div>
        </div>
    </div>
</div>
