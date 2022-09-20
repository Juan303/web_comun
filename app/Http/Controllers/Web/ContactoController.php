<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactoRequest;
use App\Mail\MailContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ContactoController extends Controller
{
    public function index(){
        return view('web.contacto');
    }

    public function sendEmail(ContactoRequest $request){
        try {
            Mail::to(env('MAIL_FROM_ADDRESS'))->locale(app()->getLocale())->send(new MailContacto($request));
            session()->flash('mensaje', ['type' => 'success', 'text'=> __('contacto.mensaje_respuesta_ok')]);
        }
        catch (\Exception $e){
            session()->flash('mensaje', ['type' => 'danger', 'text'=>__('contacto.mensaje_respuesta_ko')]);
        }
        return back();

    }

}
