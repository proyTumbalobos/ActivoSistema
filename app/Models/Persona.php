<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Persona extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'personas';

    public function sede(){
        return $this->belongsTo(sede::class, 'id_sede');
    }
    public function area(){
        return $this->belongsTo(Area::class, 'id_area');
    }

    public function tipoPersona()
    {
        return $this->belongsTo(Tipo_Persona::class, 'idTipoPersona');
    }

    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}
