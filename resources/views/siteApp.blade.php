<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="Satish Maharjan (satish.maharjan55@gmail.com)" name="author">

        <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:type" content="website">

        @if(isset($og_meta))
            <meta inertia='og:url' property="og:url" content="{{ $og_meta['og_url'] }}">
            <meta inertia='og:title' property="og:title" content="{{ $og_meta['og_title'] }}">
            <meta inertia='og:description' property="og:description" content="{{$og_meta['og_description']}}">
            <meta inertia='og:image' property="og:image" content="{{ $og_meta['og_image'] }}">
            <meta inertia="description" name="description" content="{{$og_meta['og_description']}}" />
        @else
            <meta inertia='og:url' property="og:url" content="{{ url('/')}}">
            <meta inertia='og:title' property="og:title" content="{{ config('app.name', 'Laravel') }}">
            <meta inertia='og:description' property="og:description" content="We focus on Live Aquarium Plants, selling both in our retail store and online. Live Aquatic Plants are essential to a healthy aquarium.">
            <meta inertia='og:image' property="og:image" content="{{ getAppInfo('brand_logo') }}">
            <meta inertia="description" name="description" content="We focus on Live Aquarium Plants, selling both in our retail store and online. Live Aquatic Plants are essential to a healthy aquarium." />

        @endif
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="628">


        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('/web-site/assets/css/animate.css')}}">
        <link rel="stylesheet" href="{{ asset('/web-site/assets/css/swiper-bundle.css')}}">
        <link rel="stylesheet" href="{{ asset('/web-site/assets/css/spacing.css')}}">
        <link rel="stylesheet" href="{{ asset('/web-site/assets/css/meanmenu.css')}}">
        <link rel="stylesheet" href="{{ asset('/web-site/assets/css/icon-dukamarket.css')}}">
        <link rel="stylesheet" href="{{ asset('/web-site/assets/css/main.css')}}">
        <script
            src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
            crossorigin="anonymous"></script>
        <script src="{{ asset('/web-site/assets/js/waypoints.js')}}"></script>
        <script src="{{ asset('/web-site/assets/js/countdown.js')}}"></script>
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
