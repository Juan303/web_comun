<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticiaRequest;
use App\Http\Requests\UsuarioRequest;
use App\Models\CategoriaNoticia;
use App\Models\Noticias;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UsuariosController extends Controller
{

    use SendsPasswordResetEmails;

    public $botonesCrud = [
        'editar' => [
            'es'
        ],
        'activar' => true,
        'borrar'=> true,
        'email' => true,
        'verificar_email' => true,
    ];


    public function index(){
        $usuarios = Usuario::all();
        return view('admin.usuarios.index')->with(compact('usuarios'));
    }

    public function listar(){
        $usuarios = Usuario::all();
        return DataTables::of($usuarios)
            ->setRowClass(function($row){
                if((!$row->Estado)){
                    return 'table-secondary';
                }
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->format('d/m/Y');
            })
            ->editColumn('email_verified_at', function($row){
                return (!empty($row->email_verified_at))?Carbon::parse($row->email_verified_at)->format('d/m/Y'):"";
            })
            ->addColumn('acciones', function($row){
                return view('admin.usuarios.partials.botones')->with(['usuario' => $row, 'botonesCrud' => $this->botonesCrud]);
            })
            ->rawColumns(['acciones'])
            ->make(true);
    }

    public function crear(){
        return view('admin.usuarios.crear');
    }

    public function guardar(UsuarioRequest $request){
        DB::beginTransaction();
        try {
            //===========================================DATOS
            //=========Guardo en español por defecto
            $usuario = Usuario::create([
                'name' => $request->post('nombre'),
                'email' => $request->post('email'),
                'password' => Hash::make($request->post('password')),
                'email_verified_at' => time()
            ]);
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>'Usuario registrado correctamente']);
            return redirect(route('admin.usuarios.index'));
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
            return back();
        }
    }

    public function editar(Usuario $usuario, $idioma){
        return view('admin.usuarios.editar')->with(compact('usuario'))->with(['idioma' => $idioma]);
    }

    public function actualizar(UsuarioRequest $request, Usuario $usuario){

        $datos = [
            'name' => $request->post('nombre'),
            'email' => $request->post('email'),
        ];
        if(!empty($request->post('password'))){
            $datos['password'] = Hash::make($request->post('password'));
        }

        DB::beginTransaction();
        try {
            $usuario->update($datos);
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>'Usuario actualizado correctamente']);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
        }
        return back();
    }

    public function borrar(Usuario $usuario){
        DB::beginTransaction();
        try {
            $usuario->delete();
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>'Usuario actualizado correctamente']);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
        }
        //enviar mensaje JSON para mostrar ventana
    }

    public function cambiarEstado(Usuario $usuario){
        DB::beginTransaction();
        try {
            $usuario->Estado = !$usuario->Estado;
            $usuario->save();
            $mensaje = ($usuario->Estado)?"Usuario activado":"Usuario desactivado";
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>$mensaje]);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>"Error al cambiar el estado del usuario: ".$e->getMessage()]);
        }
        return back();
    }

   public function envioMailRecuperarPass(Usuario $usuario){
       DB::beginTransaction();
       try {
           $token = Str::random(64);
           $usuario->sendPasswordResetNotification($token);
           DB::commit();
           session()->flash('mensaje', ['type' => 'success', 'text'=> 'E-mail con el link de reseteo de contraseña enviado']);
       }
       catch (\Exception $e){
           session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
       }
       return back();
   }

    public function envioMailVerificarCorreo(Usuario $usuario){
        DB::beginTransaction();
        try {
            $usuario->sendEmailVerificationNotification();
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=> 'E-mail para verificar el correo enviado']);
        }
        catch (\Exception $e){
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
        }
        return back();
    }

}
