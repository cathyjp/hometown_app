<?php

use function Livewire\Volt\{state, title};
use App\Models\Reasons;

title('ふるさと住民制度｜平泉町');

// reasonsテーブルからデータを取得
$reasons = Reasons::all();

state(['reasons' => $reasons]);

?>

<div>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">

    <div class="main-visual">
        <div class="slideshow-container">
            <div class="slideshow-slide fade" style="display: block;">
                <img src="{{ asset('images/main-visual/main-visual-1.jpg') }}" alt="平泉町ふるさと住民制度メインビジュアル1"
                    class="main-visual-image">
            </div>
            <div class="slideshow-slide fade">
                <img src="{{ asset('images/main-visual/main-visual-2.jpg') }}" alt="平泉町ふるさと住民制度メインビジュアル2"
                    class="main-visual-image">
            </div>
            <div class="slideshow-slide fade">
                <img src="{{ asset('images/main-visual/main-visual-3.jpg') }}" alt="平泉町ふるさと住民制度メインビジュアル3"
                    class="main-visual-image">
            </div>
            <div class="slideshow-slide fade">
                <img src="{{ asset('images/main-visual/main-visual-4.jpg') }}" alt="平泉町ふるさと住民制度メインビジュアル4"
                    class="main-visual-image">
            </div>
        </div>
    </div>

    <div class="about-container">
        <div class="sections-row">
            <div class="content-box">
                <h2>ふるさと住民制度とは</h2>
                <p>
                    平泉町では、町にゆかりのある方や愛着がある方、応援したいと思っている方へ、特典やサービス、イベント等の情報を提供することにより繋がりを深め、魅力ある地域づくり、交流の推進、移住・定住の促進、繋がりによって地域が活性化することを目的に「ふるさと住民制度」を創設しました。
                </p>
            </div>
            <div class="content-box">
                <h2>ふるさと住民の特典</h2>
                <ul class="benefit-list">
                    <li>ふるさと住民票カードの発行</li>
                    <li>広報誌の送付</li>
                    <li>イベント等の情報提供</li>
                    <li>空き家情報のプレミアム公開</li>
                    <li>先輩移住者との座談会参加権</li>
                    <li>空き家内見ツアーの先行予約権</li>
                    <li>町の計画、政策へのパブリックコメント参加</li>
                </ul>
                <p class="note">※ 今後追加予定</p>
            </div>
        </div>
        <div class="content-box">
            <h2>ふるさと住民の対象者</h2>
            <p>次のいずれかに該当する方で、年齢、性別および国籍は問いません。</p>
            <ul class="eligibility-list">
                @foreach ($reasons as $reason)
                    <li>
                        <label>
                            <input type="radio" name="reason" value="{{ $reason->id }}"
                                id="reason_{{ $reason->id }}">
                            {{ $reason->description }}
                        </label>
                    </li>
                @endforeach
            </ul>
            <div class="btn-container">
                <div class="btn-message" id="btn-message">上記から該当する項目を選択してください</div>
                <a href="{{ route('hometown.register.email') }}" class="btn btn-large" id="register-btn"
                    onclick="return checkReasonSelected();">
                    ふるさと住民登録申請をする
                </a>
            </div>
        </div>
    </div>
    <div class="about-spacer"></div>
</div>

<script>
    // about-containerの位置と高さに基づいて、フッターとの間にスペースを確保
    document.addEventListener('DOMContentLoaded', function() {
        const aboutContainer = document.querySelector('.about-container');
        const aboutSpacer = document.querySelector('.about-spacer');

        if (aboutContainer && aboutSpacer) {
            // about-containerの位置と高さを取得
            const containerRect = aboutContainer.getBoundingClientRect();
            const containerTop = containerRect.top + window.scrollY;
            const containerHeight = aboutContainer.offsetHeight;

            // about-containerの下端の位置を計算（top + height）
            const containerBottom = containerTop + containerHeight;

            // メインビジュアルの下端の位置を取得
            const mainVisual = document.querySelector('.main-visual');
            const mainVisualRect = mainVisual ? mainVisual.getBoundingClientRect() : null;
            const mainVisualBottom = mainVisualRect ? mainVisualRect.top + window.scrollY + mainVisualRect
                .height : 0;

            // スペーサーの高さを計算
            // about-containerの下端とメインビジュアルの下端のうち大きい方から、フッターとの余白（50px）を引いた値
            const spacerHeight = Math.max(containerBottom - mainVisualBottom, 0) + 50;

            aboutSpacer.style.height = spacerHeight + 'px';
        }

        // ボタンを初期状態で無効化
        const registerBtn = document.getElementById('register-btn');
        if (registerBtn) {
            registerBtn.classList.add('btn-disabled');
        }

        // ラジオボタンの選択を監視
        const radioButtons = document.querySelectorAll('input[name="reason"]');
        radioButtons.forEach(function(radio) {
            radio.addEventListener('change', function() {
                updateButtonState();
            });
        });

        // 初期状態を確認
        updateButtonState();
    });

    // ボタンの状態を更新
    function updateButtonState() {
        const registerBtn = document.getElementById('register-btn');
        const btnMessage = document.getElementById('btn-message');
        const selectedReason = document.querySelector('input[name="reason"]:checked');

        if (registerBtn && btnMessage) {
            if (selectedReason) {
                registerBtn.classList.remove('btn-disabled');
                registerBtn.style.pointerEvents = 'auto';
                registerBtn.style.opacity = '1';
                btnMessage.style.display = 'none';
            } else {
                registerBtn.classList.add('btn-disabled');
                registerBtn.style.pointerEvents = 'none';
                registerBtn.style.opacity = '0.5';
                btnMessage.style.display = 'block';
            }
        }
    }

    // ボタンクリック時のチェック
    function checkReasonSelected() {
        const selectedReason = document.querySelector('input[name="reason"]:checked');
        if (!selectedReason) {
            alert('対象者を選択してください。');
            return false;
        }
        return true;
    }

    // リサイズ時も再計算
    window.addEventListener('resize', function() {
        const aboutContainer = document.querySelector('.about-container');
        const aboutSpacer = document.querySelector('.about-spacer');

        if (aboutContainer && aboutSpacer) {
            const containerRect = aboutContainer.getBoundingClientRect();
            const containerTop = containerRect.top + window.scrollY;
            const containerHeight = aboutContainer.offsetHeight;
            const containerBottom = containerTop + containerHeight;

            const mainVisual = document.querySelector('.main-visual');
            const mainVisualRect = mainVisual ? mainVisual.getBoundingClientRect() : null;
            const mainVisualBottom = mainVisualRect ? mainVisualRect.top + window.scrollY + mainVisualRect
                .height : 0;

            const spacerHeight = Math.max(containerBottom - mainVisualBottom, 0) + 50;

            aboutSpacer.style.height = spacerHeight + 'px';
        }
    });
</script>
