<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="Satish Maharjan (satish.maharjan55@gmail.com)" name="author">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="/web-site/assets/css/animate.css">
        <link rel="stylesheet" href="/web-site/assets/css/swiper-bundle.css">
        <link rel="stylesheet" href="/web-site/assets/css/spacing.css">
        <link rel="stylesheet" href="/web-site/assets/css/meanmenu.css">
        <link rel="stylesheet" href="/web-site/assets/css/icon-dukamarket.css">
        <link rel="stylesheet" href="/web-site/assets/css/main.css">
        <script
            src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
            crossorigin="anonymous"></script>
        <script src="/web-site/assets/js/waypoints.js"></script>
        <script src="/web-site/assets/js/countdown.js"></script>
        <script src="{{ asset('/web-site/assets/js/main.js') }}"></script>

        <!-- Scripts -->
        @routes
        @vite('resources/js/site.js','web-site/build')
        @inertiaHead
        <script>
            window.addEventListener('DOMContentLoaded', (event) => {
                @if ($message = Session::get('success'))
                vt.success("{{ $message }}")
                @elseif ($message = Session::get('info'))
                vt.info("{{ $message }}")
                @elseif ($message = Session::get('error'))
                vt.error("{{ $message }}")
                @elseif ($message = Session::get('warning'))
                vt.warn("{{ $message }}")
                @endif
            });
        </script>
        <script>
            window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'siteUrl' => url('/'),
        ]) !!};
        </script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
<script src="{{ asset('/web-site/assets/js/tostify.js') }}"></script>
