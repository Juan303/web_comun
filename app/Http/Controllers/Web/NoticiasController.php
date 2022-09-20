<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Models\Noticias;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class NoticiasController extends Controller
{
    public function index(){
        $noticias = Noticias::activas()->get();
        return view('web.noticias')->with(compact('noticias'));
    }

    public function mostrar($slug){
        $objNoticia = new Noticias();
        $noticia = $objNoticia->findBySlug($slug, app()->getLocale());
        if($noticia->Slug === $slug){
            return view('web.noticia')->with(compact('noticia'));
        }
        return redirect(route('noticias.mostrar', ['noticia'=>$noticia->Slug]));
    }
    
}
