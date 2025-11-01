<?php

use function Livewire\Volt\{state, title};

title('ふるさと住民制度｜平泉町');

?>

<link rel="stylesheet" href="{{ asset('css/about.css') }}">

<div class="about-container">
    <div class="about-content">
        <h1 class="about-title">ふるさと住民登録制度</h1>

        <section class="about-section">
            <h2 class="section-title">ふるさと住民制度とは</h2>
            <p class="section-text">
                平泉町では、町にゆかりのある方や愛着がある方、応援したいと思っている方へ、特典やサービス、イベント等の情報を提供することにより繋がりを深め、魅力ある地域づくり、交流の推進、移住・定住の促進、繋がりによって地域が活性化することを目的に「ふるさと住民制度」を創設しました。
            </p>
        </section>

        <section class="about-section">
            <h2 class="section-title">ふるさと住民の特典</h2>
            <ul class="benefit-list">
                <li>ふるさと住民票カードの発行</li>
                <li>広報誌の送付</li>
                <li>イベント等の情報提供</li>
                <li>空き家情報のプレミアム公開</li>
                <li>先輩移住者との座談会参加権</li>
                <li>空き家内見ツアーの先行予約権</li>
                <li>町の計画、政策へのパブリックコメント参加</li>
            </ul>
            <p class="note">※今後追加予定</p>
        </section>

        <section class="about-section">
            <h2 class="section-title">ふるさと住民の対象者</h2>
            <p class="section-text">次のいずれかに該当する方で、年齢、性別および国籍は問いません。</p>
            <ul class="eligibility-list">
                <li>町の出身者</li>
                <li>家族または親戚が町に住み、または住んでいた方</li>
                <li>町にふるさと応援寄付条例に規定するふるさと応援寄附金を行った方</li>
                <li>町内に固定資産を有している方</li>
                <li>町に通勤し、通学し、またはしていた方</li>
                <li>町出身者等で構成するふるさと会等の団体に所属している方</li>
                <li>町内での起業および町内企業への就職を促進するために町が実施する事業を終了した方</li>
            </ul>
        </section>

        <div class="register-button-container">
            <a href="{{ route('hometown.register.email') }}" class="register-button">
                ふるさと住民登録申請をする
            </a>
        </div>
    </div>
</div>
