@extends('admin.templates.template')

@section ('head')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Crear Noticia</h3>
                <form action="{{ route('admin.noticias.guardar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="Titulo" id="titulo" value="{{ old('Titulo') }}" aria-describedby="tituloHelp">
                           {{-- <div id="tituloHelp" class="form-text">Escribe un título</div>--}}
                            @error('Titulo')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="titulo" class="form-label">Categoría</label>
                            <select name="categorias_noticia_id" id="categorias_noticia_id" class="form-select" aria-label="Default select example">
                                <option value="" selected>--Sin categoria --</option>
                                @foreach($categoriasNoticias as $categoriaNoticia)
                                    <option value="{{ $categoriaNoticia->id }}">{{ $categoriaNoticia->Titulo }}</option>
                                @endforeach
                            </select>
                            @error('categorias_noticia_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="FechaInicio" class="form-label">Fecha de Inicio</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" value="{{ old('FechaInicio') }}" name="FechaInicio" id="FechaInicio" class="form-control">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="FechaFin" class="form-label">Fecha Fin</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" name="FechaFin" value="{{ old('FechaFin') }}" id="FechaFin" class="form-control">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="Imagen" class="form-label">Imagen</label>
                        <input class="form-control" name="Imagen" type="file" id="Imagen">
                        @error('Imagen')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="texto" class="form-label">Texto</label>
                        <textarea class="form-control" name="Texto" id="Texto" rows="3"  aria-describedby="textoHelp">{{ old('Texto') }}</textarea>
                        @error('Texto')
                            <div class="alert alert-danger">{{ $message }}</div>
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
                    <a href="{{ route('admin.noticias.index') }}" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section ('scripts')
    <script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript">
        //Configuracion CKEditor
        $(document).ready(function () {
            var editor = CKEDITOR.replace( 'Texto', {
                removeDialogTabs : 'link:upload;image:Upload',
                toolbarGroups: [
                    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
                    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
                    { name: 'links' },
                    { name: 'insert' },
                    { name: 'forms' },
                    { name: 'tools' },
                    { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
                    { name: 'others' },
                    '/',
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                    { name: 'styles' },
                    { name: 'colors' },
                    { name: 'about' }
                ]
            });
            //Integrar CKFinder en CKeditor
            CKFinder.setupCKEditor(editor, {

                type: 'Imagenes noticias',
                currentFolder : '/public/'
            });
        });
    </script>
    @include('ckfinder::setup')
@endsection
