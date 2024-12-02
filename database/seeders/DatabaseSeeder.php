<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\CategoriaActivo;
use App\Models\sede;
use App\Models\TipoFicha;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        CategoriaActivo::factory()->create([
            'name'=>'Laptop'
        ]);
        CategoriaActivo::factory()->create([
            'name'=>'PC'
        ]);
        CategoriaActivo::factory()->create([
            'name'=>'Monitor'
        ]);
        CategoriaActivo::factory()->create([
            'name'=>'Impresora'
        ]);

        sede::factory()->create([
            'ruc'=>'46455457',
            'nombre'=>'sede1',
            'direccion'=>'calle de prueba 1'
        ]);
        sede::factory()->create([
            'ruc'=>'46451157',
            'nombre'=>'sede2',
            'direccion'=>'calle de prueba 2'
        ]);
        sede::factory()->create([
            'ruc'=>'46225457',
            'nombre'=>'sede3',
            'direccion'=>'calle de prueba 3'
        ]);

        Area::factory()->create([
            "nombre"=>'Administrador'
        ]);
        Area::factory()->create([
            "nombre"=>'logistica'
        ]);
        Area::factory()->create([
            "nombre"=>'TI'
        ]);
        Area::factory()->create([
            "nombre"=>'MARKETING'
        ]);
        Area::factory()->create([
            "nombre"=>'RRHH'
        ]);
        
        
        TipoFicha::factory()->create([
            'nombre'=>'asignación'
        ]);
        TipoFicha::factory()->create([
            'nombre'=>'devolución'
        ]);
        TipoFicha::factory()->create([
            'nombre'=>'prestamo'
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
