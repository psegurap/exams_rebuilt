<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamenCompletado extends Model
{
    use SoftDeletes;

    protected $table = 'examenes_completados';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function examen()
    {
        return $this->belongsTo('App\Models\Examen', 'template_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
