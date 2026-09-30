<?php

namespace Database\Factories;

use App\Models\Condominio;
use App\Models\TipoCondominio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Condominio>
 */
class CondominioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => 'Condominio '.fake()->unique()->company(),
            'tipo_condominio_id' => TipoCondominio::factory(),
            'user_id' => User::factory(),
        ];
    }
}
