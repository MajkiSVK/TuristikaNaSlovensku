<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{URL::asset('css/app.css')}}">

        <!-- My CSS -->
        <link rel="stylesheet" href="{{URL::asset('css/style.css')}}">

        <!-- Scripts -->
        <script src="{{ URL::asset('js/app.js') }}" defer></script>

        <title>Turistika na Slovensku</title>
    </head>
    <body class="{{ Request::segment(1) ?: 'main' }}">
        <main>
            <!-- Class yielding for customization specific pages -->
            <div class="container @yield('class')">

                @include('partials.flash_messages')
                <!-- Yielding the main content of the page -->
                @yield('container')
            </div>

        </main>
    </body>
</html>
