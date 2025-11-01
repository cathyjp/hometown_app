<?php

use App\Http\Controllers\ProfileController;
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
Volt::route('/hometown/register/form', 'register-form')->middleware(['auth', 'verified'])->name('hometown.register.form');

// 入力内容確認画面
Volt::route('/hometown/register/confirm', 'register-confirm')->middleware(['auth', 'verified'])->name('hometown.register.confirm');

// 登録申請完了画面
Volt::route('/hometown/register/complete', 'register-complete')->middleware(['auth', 'verified'])->name('hometown.register.complete');

// ダッシュボード
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// プロフィール
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
