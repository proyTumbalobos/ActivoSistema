<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;
    protected $guarded = [];
    // En el modelo Incidencia

    public function area(){
        return $this->belongsTo(Area::class, 'id_area');
    }
    public function sede(){
        return $this->belongsTo(sede::class, 'id_sede');
    }
    public function personalEncargado() {
        return $this->belongsTo(Persona::class, 'id_personal'); // Relación con la tabla personas
    }

}
