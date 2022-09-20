<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\NoticiasController;
use App\Http\Controllers\Web\ContactoController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\Auth\ResetPasswordController;
use App\Http\Controllers\Web\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//=================CONTROL DE LA BARRA DE DEBUG
Route::get('/switch-debug/{zona}/{desactivarDebug}', function($zona, $desactivarDebug){
    Session::put('desactivarDebug', $desactivarDebug);
    \App\Csnet\Debug::setDatabase();
    Auth::guard('admin')->logout();
    Auth::guard('web')->logout();
    return redirect('/'.(($zona === 'admin')?$zona:''));
})->name("switch-debug");

Route::get('/ocultar-debug/{ocultarDebug}', function($ocultarDebug){
    Session::put('ocultarDebug', $ocultarDebug);
})->name("ocultar-debug");
//=================FIN CONTROL DE LA BARRA DE DEBUG


$middelwares_idiomas = $middelwares_autentificacion = [];
$prefix_idiomas = "";
//===================================CON MULTI-IDIOMA
if(env('MULTI_IDIOMA')){
    $prefix_idiomas = LaravelLocalization::setLocale();
    $middelwares_idiomas = ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localize'];
}

//===================================CON LOGIN
if(env('TIENE_LOGIN')) {
    Route::prefix($prefix_idiomas)->middleware($middelwares_idiomas)->group(function(){
        //Cargar todas las rutas del login una a una individualmente
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
        Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
        Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
        Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
        Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
        //Auth::routes(['verify' => true]);
    });
    $middelwares_autentificacion =  ['verified', 'auth:web'];
}

//Cookies
Route::middleware($middelwares_idiomas)->prefix($prefix_idiomas)->group(function() use($middelwares_autentificacion){
    //==========RUTAS QUE NO NECESITAN AUTENTICACION (EN CASO DE ESTAR ACTIVADA LA AUTENTICACION)
    //INDEX
    Route::get('/', [IndexController::class, 'index'])->name('index');
    //COOKIES
    Route::get('/politica-de-cookies', function(){
        return view('web.politica-de-cookies');
    })->name('politica-de-cookies');

    //==========RUTAS QUE NECESITAN AUTENTICACION (EN CASO DE ESTAR ACTIVADA LA AUTENTICACION)
    Route::middleware($middelwares_autentificacion)->group(function(){
        //Noticias
        Route::get(LaravelLocalization::transRoute('routes.noticias'), [NoticiasController::class, 'index'])->name('noticias');
        Route::get(LaravelLocalization::transRoute('routes.noticias.mostrar'), [NoticiasController::class, 'mostrar'])->name('noticias.mostrar');
        //Contacto
        Route::get(LaravelLocalization::transRoute('routes.contacto'), [ContactoController::class, 'index'])->name('contacto');
        Route::post('/contacto', [ContactoController::class, 'sendEmail'])->name('contacto.enviar');
    });

});








