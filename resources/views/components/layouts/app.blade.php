<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap');

        /* ファビコンの色を設定（SVGの場合） */
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

    <!-- ファビコン設定 -->
    <link rel="icon" href="{{ asset('favicon.svg') }}?v={{ time() }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v={{ time() }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body>
    {{ $slot }}
</body>

</html>
