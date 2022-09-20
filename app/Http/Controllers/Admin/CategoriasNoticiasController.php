<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaNoticiaRequest;
use App\Http\Requests\NoticiaRequest;
use App\Models\CategoriaNoticia;
use App\Models\Noticias;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoriasNoticiasController extends Controller
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
        $categoriaNoticia = CategoriaNoticia::all();
        return view('admin.categoriasNoticias.index')->with(compact('categoriaNoticia'));
    }

    public function listar(){
        $categoriasNoticias = CategoriaNoticia::select(['id', 'Titulo', 'Estado', 'Slug']);
        return DataTables::eloquent($categoriasNoticias)
            ->setRowClass(function($row){
                if((!$row->Estado)){
                    return 'table-secondary';
                }
            })
            ->addColumn('acciones', function($row){
                return view('admin.categoriasNoticias.partials.botones')->with(['categoriaNoticia' => $row, 'botonesCrud' => $this->botonesCrud]);
            })
            ->rawColumns(['acciones'])
            ->make(true);
    }

    public function crear(){
        return view('admin.categoriasNoticias.crear')->with(['idioma' => App::getLocale()]);
    }

    public function guardar(CategoriaNoticiaRequest $request){
        DB::beginTransaction();
        try {

            //===========================================DATOS
            //=========Guardo en español por defecto
            $categoriaNoticia = CategoriaNoticia::create([
                'Titulo' => ['es' => $request->post('Titulo')]
            ]);

            //===========================================IMAGEN

            if($request->hasFile('Imagen')){
                $imagen = $request->file('Imagen');
                $nombreImagen = $imagen->hashName();
                $imagen->storeAs('images/categoriasNoticias/'.$categoriaNoticia->id, $nombreImagen,'public');
                $categoriaNoticia->Imagen = $nombreImagen;
                $categoriaNoticia->save();
            }

            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>'Categoria noticia registrada correctamente']);
            return redirect(route('admin.categoriasNoticias.index'));
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
            return back();
        }

    }

    public function editar($slug, $idioma){
        $objCategoriaNoticia = new CategoriaNoticia();
        $categoriaNoticia = $objCategoriaNoticia->findBySlug($slug, $idioma);
        return view('admin.categoriasNoticias.editar')->with(compact('categoriaNoticia', 'idioma'));
    }

    public function actualizar(CategoriaNoticiaRequest $request, $slug, $idioma){
        $objCategoriaNoticia = new CategoriaNoticia();
        $categoriaNoticia = $objCategoriaNoticia->findBySlug($slug, $idioma);
        DB::beginTransaction();
        try {
            //==============Seteamos los datos sin idioma
            //=====ESTADO
            $categoriaNoticia->Estado = ($request->post('Estado'))?true:false;
            //=====Activacion

            //==============Seteamos el idioma que toque
            $categoriaNoticia
                ->setTranslation('Titulo', $idioma, $request->post('Titulo'))
                ->setTranslation('Slug', $idioma,  Str::slug($request->post('Titulo')));
            //===========================================IMAGEN
            if($request->post('borrarImagen')){
                Storage::disk('public')->deleteDirectory('images/categoriasNoticias/'.$categoriaNoticia->id);
                $categoriaNoticia->Imagen = null;
            }
            elseif($request->hasFile('Imagen')){
                Storage::disk('public')->delete('images/categoriasNoticias/'.$categoriaNoticia->id."/".$categoriaNoticia->Imagen);
                $imagen = $request->file('Imagen');
                $nombreImagen = $imagen->hashName();
                $imagen->storeAs('images/categoriasNoticias/'.$categoriaNoticia->id, $nombreImagen,'public');
                $categoriaNoticia->Imagen = $nombreImagen;
            }
            //=====Guardamos el modelo
            $categoriaNoticia->save();
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>'Categoria Noticia actualizada correctamente']);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
        }
        return redirect(route('admin.categoriasNoticias.editar', ['categoriaNoticia' => $categoriaNoticia->translate('Slug', $idioma, false), 'idioma' => $idioma]));
    }

    public function borrar($slug){
        $objCategoriaNoticia = new CategoriaNoticia();
        $categoriaNoticia = $objCategoriaNoticia->findBySlug($slug,'es');
        DB::beginTransaction();
        try {
            $categoriaNoticia->delete();
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>'Noticia eliminada correctamente']);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
        }
    }

    public function cambiarEstado($slug){
        $objCategoriaNoticia = new CategoriaNoticia();
        $categoriaNoticia = $objCategoriaNoticia->findBySlug($slug,'es');
        DB::beginTransaction();
        try {
            if ($categoriaNoticia->Estado) {
                $categoriaNoticia->Estado = false;
                $mensaje = "Categoria noticia desactivada";
            } else {
                $categoriaNoticia->Estado = true;
                $mensaje = "Categoria noticia activada";
            }
            $categoriaNoticia->save();
            DB::commit();
            session()->flash('mensaje', ['type' => 'success', 'text'=>$mensaje]);
        }
        catch (\Exception $e){
            DB::rollBack();
            session()->flash('mensaje', ['type' => 'danger', 'text'=>$e->getMessage()]);
        }
    }

}
