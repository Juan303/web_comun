@extends('admin.templates.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Editar Noticia ({{ strtoupper($idioma) }}): ({{ $noticia->translate('Titulo', 'es', false) }})</h3>
                <form action="{{ route('admin.noticias.actualizar', ['noticia' => $noticia->translate('Slug', $idioma, false), 'idioma' => $idioma]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="exampleInputEmail1" class="form-label">Título</label>
                            <input type="text" class="form-control" name="Titulo" id="titulo" value="{{ old('Titulo', $noticia->translate('Titulo', $idioma, false)) }}" aria-describedby="tituloHelp">
                            {{-- <div id="tituloHelp" class="form-text">Escribe un título</div>--}}
                            @error('Titulo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="titulo" class="form-label">Categoría</label>
                            <select name="categorias_noticia_id" id="categorias_noticia_id" class="form-select" aria-label="Default select example">
                                <option value="" selected>--Sin categoria --</option>
                                @foreach($categoriasNoticias as $categoriaNoticia)
                                    <option @if($noticia->categorias_noticia_id == $categoriaNoticia->id) selected @endif value="{{ $categoriaNoticia->id }}">{{ $categoriaNoticia->Titulo }}</option>
                                @endforeach
                            </select>
                            @error('categorias_noticia_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if($idioma == 'es')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="FechaInicio" class="form-label">Fecha de Inicio</label>
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" value="{{ old('FechaInicio' ,\Carbon\Carbon::parse($noticia->FechaInicio)->format('d/m/Y')) }}" name="FechaInicio" id="FechaInicio" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="FechaFin" class="form-label">Fecha Fin</label>
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" name="FechaFin" value="{{ old('FechaFin', (!empty($noticia->FechaFin))?\Carbon\Carbon::parse($noticia->FechaFin)->format('d/m/Y'):"") }}" id="FechaFin" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="Imagen" class="form-label"> @if (!empty($noticia->Imagen))Sustituir imagen @else Imagen @endif</label>
                            <input class="form-control" name="Imagen" type="file" id="Imagen">
                            @error('Imagen')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @if (!empty($noticia->Imagen))
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="borrarImagen" value="1" id="borrarImagen">
                                    <label class="form-check-label" for="borrarImagen">
                                        Borrar imagen
                                    </label>
                                </div>
                            @endif
                        </div>
                        @if (!empty($noticia->Imagen))
                            <div class="mb-3 col-md-3">
                                <img src="{{ asset("/storage/images/noticias/".$noticia->id."/".$noticia->Imagen) }}" class="img img-fluid" alt="">
                            </div>
                        @endif
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="texto" class="form-label">Texto</label>
                        <textarea class="form-control" name="Texto" id="Texto" rows="3"  aria-describedby="textoHelp">{{ old('Texto', $noticia->translate('Texto', $idioma, false)) }}</textarea>
                        {{--<div id="textoHelp" class="form-text">Escribe un texto</div>--}}
                        @error('Texto')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="Estado" @if($noticia->Estado) checked @endif value="1" id="Estado">
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
            var ckeditor = CKEDITOR.replace( 'Texto', {
                //Las 2 lineas siguientes son para activar la carga de imagenes de manera individual
            {{--filebrowserUploadUrl: "{{ route('admin.noticias.ckeditor.upload', ['_token' => csrf_token()])}}",
                filebrowserUploadMethod : "form",--}}
                filebrowserUploadUrl : '',
                filebrowserImageUploadUrl : '',
                filebrowserFlashUploadUrl : '',
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
            CKFinder.setupCKEditor(ckeditor, {
                type: 'Imagenes noticias',
                currentFolder : '/'
            });
        });
    </script>
    @include('ckfinder::setup')
@endsection
