@extends('web.templates.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $noticia->Titulo }}</div>
                    <div class="card-body">
                       <p>{!! $noticia->Texto !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
