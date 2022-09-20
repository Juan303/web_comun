{{--=======================IDIOMAS--}}
@foreach (config('languages') as $locale => $isoData)
    @if(in_array($locale, $botonesCrud['editar']))
        <a href="{{ route('admin.categoriasNoticias.editar', ['categoriaNoticia' => $categoriaNoticia->translate('Slug', $locale, false), 'idioma' => $locale]) }}" class="btn btn-sm btn-info">{{ strtoupper($locale) }}</a>
    @endif
@endforeach

{{--=======================ACTIVAR/DESACTIVAR--}}
@if($botonesCrud['activar'])
    <form action="{{ route("admin.categoriasNoticias.cambiarEstado", ['categoriaNoticia' => $categoriaNoticia->translate('Slug', 'es', false)]) }}" method="post" class="d-inline activar-desactivar-form">
        @csrf
        @method('PUT')
        @if($categoriaNoticia->Estado)
            <button type="submit" class="btn btn-sm btn-success">OFF</button>
        @else
            <button type="submit" class="btn btn-sm btn-warning">ON</button>
        @endif
    </form>
@endif

{{--=======================BORRAR--}}
@if($botonesCrud['borrar'])
    <button type="button" class="btn btn-sm btn-danger btn-borrar-registro" data-action="{{ route('admin.categoriasNoticias.borrar', ['categoriaNoticia' => $categoriaNoticia->translate('Slug', 'es', false)]) }}">
        DEL
    </button>
@endif

