<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ficha extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function activos()
    {
        return $this->belongsToMany(activo::class, 'activo_ficha');
    }

    public function persona(){
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function tipo(){
        return $this->belongsTo(TipoFicha::class, 'id_tipo');
    }
}
