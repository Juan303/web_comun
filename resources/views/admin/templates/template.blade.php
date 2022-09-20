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


    <!-- Datepicker -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

    <!--  DataTables BS5 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/datatables/datatables.css') }}"/>

    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield("head")
</head>
<body>
@if(!env('DB_NO_DATABASE'))
    {{ \App\Csnet\Facades\Debug::mostrarBarraDebug('admin') }}
@endif
<div id="app">
   @include('admin.templates.partials.navigation')
    <main class="py-4">
        @include('admin.templates.partials.mensajes.general_mensajes')
        @yield('content')
    </main>
</div>
<!-- ================================= JQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<!-- ================================= Datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('/js/bootstrap-datepicker.es.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es'
        });
    })
</script>

<!-- ================================= DataTables BS5 -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/datatables.min.js"></script>
<!-- ======== DataTables BS5 Valores por defecto para todas las datatables -->
<script type="text/javascript" src="{{ asset('/js/datatables/dataTablesDefaults.js') }}"></script>

<!-- ======== DataTables BS5 Valores por defecto para todas las datatables -->
<script type="text/javascript" src="{{ asset('/js/datatables/dataTablesDefaults.js') }}"></script>

<!-- ========Scripts CRUD===== -->
<script type="text/javascript" src="{{ asset('/js/datatables/crud.js') }}"></script>

<!-- ========Scripts Barra de Debug CSnet===== -->
@if(!env('DB_NO_DATABASE'))
    <script type="text/javascript" src="{{ asset('/js/mostrarOcultarDebug.js') }}"></script>
@endif
@yield('scripts')

<!-- ================================= Ventanas modales generales -->
@include('admin.templates.partials.modales.modales')
</body>
</html>
