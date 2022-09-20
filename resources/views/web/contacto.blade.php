@extends('web.templates.template')

@section('head')
    {!! RecaptchaV3::initJs() !!}
@endsection

@section('content')
    @if(empty(session('mensaje')) || session('mensaje')['type'] === 'danger')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                            <form action="{{ route('contacto.enviar') }}" method="POST">
                                @csrf
                                <div class="card-header">{{ __('contacto.contacto') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="nombre" class="form-label">{{ __('contacto.nombre') }}</label>
                                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" value="{{ old('nombre') }}" aria-describedby="nombreHelp">
                                            @error('nombre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="email" class="form-label">{{ __('contacto.email') }}</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" aria-describedby="emailHelp">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="asunto" class="form-label">{{ __('contacto.asunto') }}</label>
                                            <input type="text" class="form-control @error('asunto') is-invalid @enderror" name="asunto" id="asunto" value="{{ old('asunto') }}" aria-describedby="asuntoHelp">
                                            @error('asunto')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="mensaje" class="form-label">{{ __('contacto.mensaje') }}</label>
                                            <textarea class="form-control @error('mensaje') is-invalid @enderror" name="mensaje" id="mensaje"  aria-describedby="mensajeHelp">{{ old('mensaje') }}</textarea>
                                            @error('mensaje')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{--===========================GOOGLE RECAPTCHA V3--}}
                                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            <div class="col-md-6">
                                                {!! RecaptchaV3::field('register') !!}
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        {{--===========================FIN GOOGLE RECAPTCHA V3--}}
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">{{ __('contacto.enviar') }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

