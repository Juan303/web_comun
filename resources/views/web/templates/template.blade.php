<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cookietool.css') }}" rel="stylesheet">
    @yield("head")
</head>
<body>
    @if(!env('DB_NO_DATABASE'))
        {{ \App\Csnet\Facades\Debug::mostrarBarraDebug() }}
    @endif
    <div id="app">
        @include('web.templates.partials.menu-superior')
        <main class="py-4">
            @include('web.templates.partials.mensajes.general_mensajes')
            @yield('content')
        </main>
    </div>
    @include('web.templates.partials.cookies')
    <!-- ================================= JQuery -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <!-- ========Scripts Barra de Debug CSnet===== -->
    @if(!env('DB_NO_DATABASE'))
        <script type="text/javascript" src="{{ asset('/js/mostrarOcultarDebug.js') }}"></script>
    @endif
    @yield('scripts')
</body>
</html>
