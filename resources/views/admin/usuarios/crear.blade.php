@extends('admin.templates.template')

@section ('head')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Crear Usuario</h3>
                <form action="{{ route('admin.usuarios.guardar') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="nombre" class="form-control" name="nombre" id="nombre" value="{{ old('nombre') }}" aria-describedby="nombreHelp">
                            @error('nombre')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" aria-describedby="emailHelp">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" value="" aria-describedby="passwordHelp">
                                <span class="input-group-text"><i class="bi bi-eye-slash togglePassword"></i></span>
                            </div>
                            @error('password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="" aria-describedby="confirmPasswordHelp">
                                <span class="input-group-text"><i class="bi bi-eye-slash togglePassword"></i></span>
                            </div>
                            @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="Estado" value="1" id="Estado">
                            <label class="form-check-label" for="Estado">
                                Estado
                            </label>
                        </div>
                    </div>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary">Volver</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section ('scripts')
    <script src="{{ asset('/js/formularios/toggleShowHiddenPassword.js') }}"></script>
@endsection
