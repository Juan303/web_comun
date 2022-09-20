<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;



Route::name('admin.')->prefix('admin')->group(function(){

    Route::namespace('Auth')->middleware('guest:admin')->group(function(){
        //login route
        Route::get('/login','LoginController@login')->name('login');
        Route::post('/login','LoginController@processLogin');
    });


    Route::namespace('Auth')->middleware('auth:admin')->group(function(){
        Route::post('/logout',function(){
            Auth::guard('admin')->logout();
            return redirect()->action([
                LoginController::class,
                'login'
            ]);
        })->name('logout');
    });

    //Noticias
    Route::middleware('auth:admin')->group(function(){
        Route::get('/', 'IndexController@index')->name('home');
        //====================================================================================NOTICIAS
        Route::name('noticias.')->prefix('/noticias')->group(function(){
            Route::get('', 'NoticiasController@index')->name('index');
            Route::get('/crear', 'NoticiasController@crear')->name('crear');
            Route::post('/guardar', 'NoticiasController@guardar')->name('guardar');
            Route::get('/{noticia}/{idioma}/editar', 'NoticiasController@editar')->name('editar');
            Route::put('/{noticia}/{idioma}/actualizar', 'NoticiasController@actualizar')->name('actualizar');
            Route::get('/{noticia}/borrar', 'NoticiasController@borrar')->name('borrar');
            Route::put('/{noticia}/cambiar-estado', 'NoticiasController@cambiarEstado')->name('cambiarEstado');

            //Peticiones datatables
            Route::get('/listar', 'NoticiasController@listar')->name('listar');

            //Subir imagenes del editor (CK)
            Route::post('/ckeditor/upload', 'NoticiasController@ckeditorUpload')->name('ckeditor.upload');
        });
        Route::name('categoriasNoticias.')->group(function(){
            Route::get('/categoriasNoticias', 'CategoriasNoticiasController@index')->name('index');
            Route::get('/categoriasNoticias/crear', 'CategoriasNoticiasController@crear')->name('crear');
            Route::post('/categoriasNoticias/guardar', 'CategoriasNoticiasController@guardar')->name('guardar');
            Route::get('/categoriasNoticias/{categoriaNoticia}/{idioma}/editar', 'CategoriasNoticiasController@editar')->name('editar');
            Route::put('/categoriasNoticias/{categoriaNoticia}/{idioma}/actualizar', 'CategoriasNoticiasController@actualizar')->name('actualizar');
            Route::get('/categoriasNoticias/{categoriaNoticia}/borrar', 'CategoriasNoticiasController@borrar')->name('borrar');
            Route::put('/categoriasNoticias/{categoriaNoticia}/cambiar-estado', 'CategoriasNoticiasController@cambiarEstado')->name('cambiarEstado');

            //Peticiones datatables
            Route::get('/categoriasNoticias/listar', 'CategoriasNoticiasController@listar')->name('listar');
        });

        //====================================================================================USUARIOS
        Route::name('usuarios.')->prefix('/usuarios')->group(function(){
            Route::get('', 'UsuariosController@index')->name('index');
            Route::get('/crear', 'UsuariosController@crear')->name('crear');
            Route::post('/guardar', 'UsuariosController@guardar')->name('guardar');
            Route::get('/{usuario}/{idioma}/editar', 'UsuariosController@editar')->name('editar');
            Route::put('/{usuario}/actualizar', 'UsuariosController@actualizar')->name('actualizar');
            Route::get('/{usuario}/borrar', 'UsuariosController@borrar')->name('borrar');
            Route::put('/{usuario}/cambiar-estado', 'UsuariosController@cambiarEstado')->name('cambiarEstado');

            Route::get('/{usuario}/envio-mail-recuperar-pass', 'UsuariosController@envioMailRecuperarPass')->name('envio-mail-recuperar-pass');
            Route::get('/{usuario}/envio-mail-verificar-mail', 'UsuariosController@envioMailVerificarCorreo')->name('envio-mail-verificar-mail');

            //Peticiones datatables
            Route::get('/listar', 'UsuariosController@listar')->name('listar');

        });

        //Subir imagenes del editor (CKFinder)
        Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
            ->name('ckfinder_connector');

        Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
            ->name('ckfinder_browser');

    });


});
