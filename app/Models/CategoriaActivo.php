<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaActivo extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productos()
    {
        return $this->hasMany(activo::class, 'id_categoria');
    }
}
