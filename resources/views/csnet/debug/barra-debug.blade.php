@if($es_debug)
    <div class="@if(!$ocultar_debug) d-none @endif" id="btnMostrarDebug" style="position: absolute; top: 0; left:0; z-index: 10000">
        <a href='{{ route('ocultar-debug', ['ocultarDebug'=>0]) }}' class='btn btn-sm btn-secondary py-0 px-0 btn-mostrar-debug' >Mostrar debug</a>
    </div>
    <div class="@if($ocultar_debug) d-none @endif row text-center justify-content-center" id="barraDebug">
        <div class="alert alert-warning col-md-2 mb-0">
            Modo Debug: <strong>ON</strong>
        </div>
        <div class="alert alert-warning col-md-2 mb-0">
            Base de datos: <strong>{{ $database }}</strong>
        </div>
        <div class="alert alert-warning col-md-2 mb-0">
            <a href='{{ route('switch-debug', ['desactivarDebug'=>1, 'zona' => $zona]) }}' class='btn btn-sm btn-secondary' >Desactivar Debug</a>
        </div>
        <div class="alert alert-warning col-md-2 mb-0">
            <a href='{{ route('ocultar-debug', ['ocultarDebug'=>1]) }}' class='btn btn-sm btn-secondary btn-ocultar-debug' >Ocultar Debug</a>
        </div>
    </div>
@elseif($es_ip_debug)
    <div style="position: absolute; top: 0; left:0; z-index: 10000">
        <a href='{{ route('switch-debug', ['desactivarDebug'=>0, 'zona' => $zona]) }}' class='btn btn-sm btn-secondary py-0 px-0' >Debug ON</a>
    </div>
@endif
