<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Forum') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{--<script src="https://kit.fontawesome.com/0782cf7c5d.js"></script>--}}
    <script>
        window.App = {!! json_encode([
        'signedIn' => Auth::check(),
        'user' => Auth::user()
        ]) !!} ;
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
    @yield('header')
    <style>
        body {padding-bottom: 100px;}
        .level {display: flex;align-items: center;}
        .flex {flex: 1;}
        [v-cloak] { display: none; }
        .ais-highlight > em {background: yellow;font-style: normal}
        pre {
            outline: auto;
            outline-color: silver;
            background: rgba(245, 245, 245, 1.0);
            padding: 0.5em;
            outline-style: dotted;
        }
    </style>
</head>
<body>
<div id="app">
    @include('layouts.nav')

    <main class="py-4">
        @yield('content')
    </main>

    <flash message="{{ session('flash') }}"></flash>
</div>
</body>
</html>
