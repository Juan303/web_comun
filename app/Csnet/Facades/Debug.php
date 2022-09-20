<?php

namespace App\Csnet\Facades;

use Illuminate\Support\Facades\Facade;

class Debug extends Facade
{
    protected static function getFacadeAccessor() //acceso a traves de la fachada
    {
        //"debug" representa a lo que se registró en el "Servide Provider" DebugServiceProvider (que está bindeado con la clase en cuestión)
        return 'debug';
    }
}
