<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Parte izquierda del menú -->
            <ul class="navbar-nav me-auto">

            </ul>
            <!-- Parte derecha del menú -->
            <ul class="navbar-nav ms-auto">
                <!-- Selector de Idioma -->
                @if(env('MULTI_IDIOMA'))
                    <li class="nav-item dropdown">
                        <a id="idiomaDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ strtoupper(app()->getLocale()) }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="idiomaDropdown">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ strtoupper($localeCode) }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                @endif
                <!-- Autentificacion de usuarios -->
                @if(!Route::has('login') || !empty(auth()->user()) || (!empty(auth()->user()) && auth()->user()->esta_verificado()))
                    @if(!Route::has('login') || (!empty(auth()->user()) && auth()->user()->esta_verificado()))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('noticias') }}" >
                                {{ __('noticias.noticias') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contacto') }}" >
                                {{ __('contacto.contacto') }}
                            </a>
                        </li>
                    @endif
                    @if(!empty(auth()->user()))
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                @if(auth()->user()->esta_verificado())
                                    {{--Opciones si el mail está verificado en el submenu del usuario--}}
                                    <a class="dropdown-item" href="">
                                        Opcion para usuarios verificados 1
                                    </a>
                                    <a class="dropdown-item" href="">
                                        Opcion para usuarios verificados 2
                                    </a>
                                    <hr>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                @else
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>
