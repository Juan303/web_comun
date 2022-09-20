<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\SlugOptions;
use Mcamara\LaravelLocalization\Interfaces\LocalizedUrlRoutable;


class Noticias extends Model implements LocalizedUrlRoutable
{
    use HasFactory, HasTranslations, HasTranslatableSlug;

    protected $fillable = ['categorias_noticia_id', 'Titulo', 'FechaInicio', 'FechaFin', 'Texto', 'Estado', 'Slug'];

    public $translatable = ['Slug', 'Titulo', 'Texto', 'categorias_noticia'];

    protected static function boot(){
        parent::boot();
        static::deleting(function($noticia){
            Storage::deleteDirectory('images/noticias/'.$noticia->id);
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::createWithLocales(['es', 'en'])
            ->generateSlugsFrom(function($model){
                return "{$model->Titulo}";
            })
            ->saveSlugsTo('Slug');
    }

    public function findBySlug($slug, $locale){
        $noticia = $this->where(function($q) use($slug, $locale){
            foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
                $q->orWhere('Slug->'.$localeCode, '=', $slug);
            }
        })->first();
        return $noticia;
    }

    public function getLocalizedRouteKey($locale)
    {
        return $this->Slug->$locale;
    }
    
    public function getRouteKeyName()
    {
        return 'Slug'; // TODO: Change the autogenerated stub
    }

    public function categorias_noticia(){
        return $this->belongsTo(CategoriaNoticia::class);
    }

    //=====SCOPES
    //Noticias publicadas y no caducadas
    public function scopeActivas($query){
        $ahora = date('Y-m-d H:m:s');
        return $query->where('Estado', '>=', 1)
            ->whereDate('FechaInicio','<=', $ahora)
            ->whereDate('FechaFin','>=', $ahora);
    }

}