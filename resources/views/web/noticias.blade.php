@extends('web.templates.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('noticias.noticias') }}</div>
                    <div class="card-body">
                        @forelse($noticias as $noticia)
                            <p><a href="{{ route("noticias.mostrar", ['noticia' => $noticia->Slug]) }}">{{$noticia->Titulo}}</a></p>
                        @empty
                            <pre>{{ __('noticias.no_hay_noticias_para_mostrar') }}</pre>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
