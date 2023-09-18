<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use SoftDeletes;

    protected $table = 'materias';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function facilitador()
    {
        return $this->belongsTo('App\Models\User', 'facilitador_id', 'id');
    }

    public function estudiante_materia()
    {
        return $this->belongsToMany('App\Models\User', 'estudiante_materia', 'materia_id', 'estudiante_id')->withTimestamps();
    }

    public function examenes(){
        return $this->hasMany('App\Models\Examen', 'materia', 'id');
    }
}
