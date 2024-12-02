<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function activo(){
        return $this->belongsTo(activo::class, 'id_activo');
    }
    public function persona(){
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
