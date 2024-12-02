<?php

namespace Database\Factories;

use App\Models\Categoria_activo;
use App\Models\CategoriaActivo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaActivoFactory extends Factory
{

    protected $model = CategoriaActivo::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
