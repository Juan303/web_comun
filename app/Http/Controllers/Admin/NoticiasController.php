<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticiaRequest;
use App\Models\CategoriaNoticia;
use App\Models\Noticias;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class NoticiasController
{
    public $botonesCrud = [
        'editar' => [
            'es',
            'en'
        ],
        'activar' => true,
        'borrar'=> true
    ];

    public function index(){
        $noticias = Noticias::all();
        return view('admin.noticias.index')->with(compact('noticias'));
    }

    public function listar(){
        $noticias = Noticias::select(['noticias.id', 'noticias.Titulo', 'noticias.Slug', 'FechaInicio', 'FechaFin', 'noticias.Estado', 'categorias_noticia_id'])->with('categorias_noticia');

        return DataTables::eloquent($noticias)
            ->setRowClass(function($row){
                if((!$row->Estado)){
                    return 'table-secondary';
                }
                elseif (!empty($row->FechaFin) && (Carbon::parse($row->FechaFin)->unix()) < time()){
                    return 'table-danger';
                }
            })
            ->editColumn('FechaInicio', function($row){
                return Carbon::parse($row->FechaInicio)->format('d/m/Y');
            })
            ->editColumn('FechaFin', function($row){
                return Carbon::parse($row->FechaFin)->format('d/m/Y');
            })
            ->addColumn('acciones', function($row){
                return view('admin.noticias.partials.botones')->with(['noticia' => $row, 'botonesCrud' => $this->botonesCrud]);
            })
            ->rawColumns(['acciones'])
            ->make(true);
    }

    public function crear(){
        $categoriasNoticias = CategoriaNoticia::all();
        return view('admin.noticias.crear')->with(['idioma' => App::getLocale()])->with(compact('categoriasNoticias'));
    }

    public function guardar(NoticiaRequest $request){
        $success = true;
        DB::beginTransaction();
        try {

            //===========================================DATOS
            //=========Guardo en español por defecto
            $noticia = Noticias::create([
                'FechaInicio' => (!empty($request->post('FechaInicio')))?Carbon::createFromFormat('d/m/Y', $request->post('FechaInicio'))->format('Y-m-d h:m:i'):"",
                'FechaFin' => (!empty($request->post('FechaFin')))?Carbon::createFromFormat('d/m/Y', $request->post('FechaFin'))->format('Y-m-d h:m:i'):null,
                'categorias_noticia_id' => (!empty($request->post('categorias_noticia_id')))?$request->post('categorias_noticia_id'):null,
                'Titulo' => ['es' => $request->post('Titulo')],
                'Texto' => ['es' => $request->post('Texto')]
            ]);

            //===========================================IMAGEN

            if($request->hasFile('Imagen')){
                $imagen = $request->file('Imagen');
                $nombreImagen = $imagen->hashName();
                $imagen->storeAs('images/noticias/'.$noticia->id, $nombreImagen,'public');
                $noticia->Imagen = $nombreImagen;
                $noticia->save();
            }


        }
        catch (\Exception $e){
            $success = $e->getMessage();
        }

        if($success === true){
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>'Noticia registrada correctamente']);
            return redirect(route('admin.noticias.index'));
        }
        else{
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$success]);
            return back();
        }
    }

    public function editar($slug, $idioma){
        $categoriasNoticias = CategoriaNoticia::all();
        $objNoticia = new Noticias();
        $noticia = $objNoticia->findBySlug($slug, $idioma);

        return view('admin.noticias.editar')->with(compact('noticia', 'idioma'))->with(compact('categoriasNoticias'));
    }

    public function actualizar(NoticiaRequest $request, $slug, $idioma){
        $objNoticia = new Noticias();
        $noticia = $objNoticia->findBySlug($slug, $idioma);
        DB::beginTransaction();
        try {
            //==============Seteamos los datos sin idioma
            //=====FECHAS
            $noticia->FechaInicio = (!empty($request->post('FechaInicio')))?Carbon::createFromFormat('d/m/Y', $request->post('FechaInicio'))->format('Y-m-d h:m:i'):$noticia->FechaInicio;
            $noticia->FechaFin = (!empty($request->post('FechaFin')))?Carbon::createFromFormat('d/m/Y', $request->post('FechaFin'))->format('Y-m-d h:m:i'):$noticia->FechaFin;
            //=====ESTADO
            if($request->exists('Estado')){
                $noticia->Estado = ($request->post('Estado'))?true:false;
            }
            //=====CATEGORIA
            $noticia->categorias_noticia_id = ($request->exists('categorias_noticia_id'))?$request->post('categorias_noticia_id'): $noticia->categorias_noticia_id;


            //==============Seteamos el idioma que toque
            $noticia
                ->setTranslation('Titulo', $idioma, $request->post('Titulo'))
                ->setTranslation('Slug', $idioma,  Str::slug($request->post('Titulo')))
                ->setTranslation('Texto', $idioma, $request->post('Texto'));
            //===========================================IMAGEN INDIVIDUAL
            if($request->post('borrarImagen')){
                Storage::disk('public')->deleteDirectory('images/noticias/'.$noticia->id);
                $noticia->Imagen = null;
            }
            elseif($request->hasFile('Imagen')){
                Storage::disk('public')->delete('images/noticias/'.$noticia->id."/".$noticia->Imagen);
                $imagen = $request->file('Imagen');
                $nombreImagen = $imagen->hashName();
                $imagen->storeAs('images/noticias/'.$noticia->id, $nombreImagen,'public');
                $noticia->Imagen = $nombreImagen;
            }
            //===========================================GRUPO DE IMAGENES
            //--CODIGO PARA GUARDAR EL GRUPO DE IMAGENES
            //=====Guardamos el modelo
            $noticia->save();
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>'Noticia actualizada correctamente']);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
            return back();
        }

        return redirect(route('admin.noticias.editar', ['noticia' => $noticia->translate('Slug', $idioma, false), 'idioma' => $idioma]));
    }

    public function borrar($slug, $locale = 'es'){
        $objNoticia = new Noticias();
        $noticia = $objNoticia->findBySlug($slug, $locale);
        DB::beginTransaction();
        try{
            $noticia->delete();
            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
        }
    }

    public function cambiarEstado($slug){
        $objNoticia = new Noticias();
        $noticia = $objNoticia->findBySlug($slug, 'es');
        $success = true;
        DB::beginTransaction();
        try {
            if ($noticia->Estado) {
                $noticia->Estado = false;
                $mensaje = "Noticia desactivada";
            } else {
                $noticia->Estado = true;
                $mensaje = "Noticia activada";
            }
            $noticia->save();
        }
        catch (\Exception $e){
            $success = $e->getMessage();
        }

        if($success){
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>$mensaje]);
        }
        else{
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>"Error al cambiar el estado de la noticia"]);
        }
        return back();
    }

    //===================CK-EDITOR
    //==============SUBIR IMAGENES
   /* public function ckeditorUpload(Request $request){
        $imagen = $request->upload;
        $nombreImagen = $imagen->hashName();
        $imagen->storeAs('images/noticias/imagenes_textos_noticias/'. $nombreImagen, 'public');
        $url =  asset("storage/images/noticias/imagenes_textos_noticias/".$nombreImagen);
        $CkeditorFuncNum = $request->input('CKEditorFuncNum');
        $status = "<script>window.parent.CKEDITOR.tools.callFunction('".$CkeditorFuncNum."', '".$url."', 'Imagen cargada!')</script>";
        echo $status;
    }*/

}
