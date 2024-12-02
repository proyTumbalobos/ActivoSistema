<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activo extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'activos';

    public function categoria(){
        return $this->belongsTo(CategoriaActivo::class, 'id_categoria');
    }

    public function fichas()
    {
        return $this->belongsToMany(ficha::class, 'activo_ficha');
    }

}
