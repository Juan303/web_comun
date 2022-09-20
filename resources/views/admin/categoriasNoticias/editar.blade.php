@extends('admin.templates.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Editar categoria noticia ({{ strtoupper($idioma) }}): ({{ $categoriaNoticia->translate('Titulo', 'es', false) }})</h3>
                <form action="{{ route('admin.categoriasNoticias.actualizar', ['categoriaNoticia' => $categoriaNoticia->translate('Slug', $idioma, false), 'idioma' => $idioma]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="Titulo" id="titulo" value="{{ old('Titulo', $categoriaNoticia->translate('Titulo', $idioma, false)) }}" aria-describedby="tituloHelp">
                        @error('Titulo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if($idioma == 'es')
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="Imagen" class="form-label"> @if (!empty($categoriaNoticia->Imagen))Sustituir imagen @else Imagen @endif</label>
                                <input class="form-control" name="Imagen" type="file" id="Imagen">
                                @error('Imagen')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (!empty($categoriaNoticia->Imagen))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="borrarImagen" value="1" id="borrarImagen">
                                        <label class="form-check-label" for="borrarImagen">
                                            Borrar imagen
                                        </label>
                                    </div>
                                @endif
                            </div>
                            @if (!empty($categoriaNoticia->Imagen))
                                <div class="mb-3 col-md-3">
                                    <img src="{{ asset("storage/images/categoriasNoticias/".$categoriaNoticia->id."/".$categoriaNoticia->Imagen) }}" class="img img-fluid" alt="">
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="Estado" @if($categoriaNoticia->Estado) checked @endif value="1" id="Estado">
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
