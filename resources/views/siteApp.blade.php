<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
{{--        <link rel="stylesheet" href="/web-site/assets/css/bootstrap.min.css">--}}
        <link rel="stylesheet" href="/web-site/assets/css/animate.css">
        <link rel="stylesheet" href="/web-site/assets/css/swiper-bundle.css">
{{--        <link rel="stylesheet" href="/web-site/assets/css/slick.css">--}}
{{--        <link rel="stylesheet" href="/web-site/assets/css/magnific-popup.css">--}}
        <link rel="stylesheet" href="/web-site/assets/css/spacing.css">
        <link rel="stylesheet" href="/web-site/assets/css/meanmenu.css">
{{--        <link rel="stylesheet" href="/web-site/assets/css/nice-select.css">--}}
{{--        <link rel="stylesheet" href="/web-site/assets/css/fontawesome.min.css">--}}
        <link rel="stylesheet" href="/web-site/assets/css/icon-dukamarket.css">
{{--        <link rel="stylesheet" href="/web-site/assets/css/jquery-ui.css">--}}
        <link rel="stylesheet" href="/web-site/assets/css/main.css">
        <script
            src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
            crossorigin="anonymous"></script>
        <script src="/web-site/assets/js/waypoints.js"></script>
{{--        <script src="/web-site/assets/js/bootstrap.bundle.min.js"></script>--}}
{{--        <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>--}}
{{--        <script src="/web-site/assets/js/swiper-bundle.js"></script>--}}
{{--        <script src="/web-site/assets/js/nice-select.js"></script>--}}
{{--        <script src="/web-site/assets/js/slick.js"></script>--}}
{{--        <script src="/web-site/assets/js/magnific-popup.js"></script>--}}
{{--        <script src="/web-site/assets/js/counterup.js"></script>--}}
{{--        <script src="/web-site/assets/js/wow.js"></script>--}}
{{--        <script src="/web-site/assets/js/isotope-pkgd.js"></script>--}}
{{--        <script src="/web-site/assets/js/imagesloaded-pkgd.js"></script>--}}
        <script src="/web-site/assets/js/countdown.js"></script>
{{--    <script src="/web-site/assets/js/ajax-form.js"></script>--}}
{{--        <script src="/web-site/assets/js/meanmenu.js"></script>--}}
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
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
<script src="{{ asset('/web-site/assets/js/tostify.js') }}"></script>
