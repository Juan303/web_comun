@extends('admin.templates.template')

@section ('head')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Crear categoria noticia</h3>
                <form action="{{ route('admin.categoriasNoticias.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="Titulo" id="titulo" value="{{ old('Titulo') }}" aria-describedby="tituloHelp">
                        @error('Titulo')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="Imagen" class="form-label">Imagen</label>
                        <input class="form-control" name="Imagen" type="file" id="Imagen">
                        @error('Imagen')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="Estado" value="1" id="Estado">
                            <label class="form-check-label" for="Estado">
                                Estado
                            </label>
                        </div>
                    </div>
                    <a href="{{ route('admin.categoriasNoticias.index') }}" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
