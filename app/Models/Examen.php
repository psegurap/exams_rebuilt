<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examen extends Model
{
    use SoftDeletes;

    protected $table = 'examenes';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function temas(){
        return $this->hasMany('App\Models\Tema', 'examen_id', 'id');
    }

    public function materia_info(){
        return $this->belongsTo('App\Models\Materia', 'materia', 'id');
    }

    public function examenes_completados()
    {
        return $this->hasMany('App\Models\ExamenCompletado', 'template_id', 'id');
    }
}
