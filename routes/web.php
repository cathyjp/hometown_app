<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ふるさと住民制度概要画面
Volt::route('/hometown/about', 'about')->name('hometown.about');

// ふるさと住民登録申請フォーム：メールアドレス入力
Volt::route('/hometown/register/email', 'register-email')->name('hometown.register.email');

// ふるさと住民登録申請フォーム：登録情報入力
Volt::route('/hometown/register/form', 'register-form')->name('hometown.register.form');

// 入力内容確認画面
Volt::route('/hometown/register/confirm', 'register-confirm')->name('hometown.register.confirm');

// ⑤登録申請完了画面
Volt::route('/hometown/register/complete', 'register-complete')->name('hometown.register.complete');
