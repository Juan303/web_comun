{{--=======================IDIOMAS--}}
@foreach (config('languages') as $locale => $isoData)
    @if(in_array($locale, $botonesCrud['editar']))
        <a href="{{ route('admin.usuarios.editar', ['usuario' => $usuario->id, 'idioma' => $locale]) }}" class="btn btn-sm btn-info">{{ strtoupper($locale) }}</a>
    @endif
@endforeach

{{--=======================ACTIVAR/DESACTIVAR--}}
@if($botonesCrud['activar'])
    <form action="{{ route("admin.usuarios.cambiarEstado", ['usuario' => $usuario->id] ) }}" method="post" class="d-inline activar-desactivar-form">
        @csrf
        @method('PUT')
        @if($usuario->Estado)
            <button type="submit" class="btn btn-sm btn-success">OFF</button>
        @else
            <button type="submit" class="btn btn-sm btn-warning">ON</button>
        @endif
    </form>
@endif

{{--=======================BORRAR--}}
@if($botonesCrud['borrar'])
    <button type="button" class="btn btn-sm btn-danger btn-borrar-registro" data-action="{{ route('admin.usuarios.borrar', ['usuario' => $usuario->id]) }}">
        DEL
    </button>
@endif

{{--=======================MAIL RECUPERAR PASS--}}

@if($botonesCrud['email'])
    <button type="button" class="btn btn-sm btn-secondary btn-envio-mail-recuperar-pass" data-action="{{ route('admin.usuarios.envio-mail-recuperar-pass', ['usuario' => $usuario->id]) }}">
        R.PASS
    </button>
@endif

{{--=======================MAIL VERIFICAR MAIL--}}

@if($botonesCrud['verificar_email'])
    @if(!isset($usuario->email_verified_at))
        <button type="button" class="btn btn-sm btn-secondary btn-envio-mail-verificar-mail" data-action="{{ route('admin.usuarios.envio-mail-verificar-mail', ['usuario' => $usuario->id]) }}">
            V.MAIL
        </button>
    @endif
@endif

