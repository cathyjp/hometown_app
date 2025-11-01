<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap');
    </style>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- ファビコン設定 -->
    <link rel="icon" href="{{ asset('favicon.svg') }}?v={{ time() }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v={{ time() }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/header-footer.css') }}">

    <!-- ファビコンの色を設定（SVGの場合） -->
    <style>
        :root {
            color-scheme: light dark;
        }

        /* ライトモード（デフォルト）の色 */
        svg {
            color: #8E2921;
            /* 濃い赤 */
        }

        /* ダークモード対応（オプション） */
        @media (prefers-color-scheme: dark) {
            svg {
                color: #ffffff;
                /* 白色 */
            }
        }
    </style>

    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body>
    <!-- ヘッダーコンポーネント -->
    <x-header />

    <!-- メインコンテンツ -->
    <main class="site-main">
        {{ $slot }}
    </main>

    <!-- フッターコンポーネント -->
    <x-footer />

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // スライドショー機能
            const slideshowSlides = document.querySelectorAll('.slideshow-slide');
            if (slideshowSlides.length > 0) {
                let slideIndex = 0;

                function showSlides() {
                    // すべてのスライドを非表示にする
                    for (let i = 0; i < slideshowSlides.length; i++) {
                        slideshowSlides[i].style.display = "none";
                        slideshowSlides[i].style.opacity = "0";
                    }

                    // 次のスライドを表示
                    slideIndex++;
                    if (slideIndex > slideshowSlides.length) {
                        slideIndex = 1;
                    }

                    slideshowSlides[slideIndex - 1].style.display = "block";
                    setTimeout(() => {
                        slideshowSlides[slideIndex - 1].style.opacity = "1";
                    }, 100);

                    // 3秒ごとに画像を切り替え
                    setTimeout(showSlides, 3000);
                }

                showSlides();
            }
        });
    </script>
</body>

</html>
