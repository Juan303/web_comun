<?php

namespace App\Csnet;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;


class Debug
{
    private static $conexion_debug = 'mysql_debug';

    public static function setDatabase(){
        if(Request::ip() === env('IP_DEBUG') && (Session::get('desactivarDebug') == null || Session::get('desactivarDebug') == 0)){
            DB::setDefaultConnection(self::$conexion_debug);
        }
    }

    public static function mostrarBarraDebug($zona = 'web'){
        $es_debug = false;
        $es_ip_debug = false;
        $ocultar_debug = false;
        if(Request::ip() === env('IP_DEBUG')){
            $es_ip_debug = true;
        }
        if(DB::getDefaultConnection() === self::$conexion_debug){ //si la conexion es con debug
            $es_debug = true;
        }
        if(Session::get('ocultarDebug') !== null && Session::get('ocultarDebug') == 1){
            $ocultar_debug = true;
        }
        $database = config('database.connections.'.DB::getDefaultConnection().'.database');
        return view('csnet.debug.barra-debug')->with(compact('database', 'es_debug', 'es_ip_debug', 'ocultar_debug', 'zona'));
    }
}
