<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->word(),
            'descricao' => fake()->optional()->text(),
            // Verifica se deve adicionar um 'categoria_id'
            'categoria_id' => function () {
                // Primeiro, verifica se existem categorias principais
                if (Categoria::whereNull('categoria_id')->exists()) {
                    // Se existir, 50% de chance de criar uma subcategoria
                    return fake()->boolean(50) ? Categoria::whereNull('categoria_id')->inRandomOrder()->first()->id : null;
                }
                // Se não houver categorias principais, retorna null (cria uma categoria principal)
                return null;
            },

            // Define o tipo baseado no categoria_id
            'tipo' => function (array $attributes) {
                // Se categoria_id foi definido, escolhe um tipo; caso contrário, null
                return isset($attributes['categoria_id']) ? fake()->randomElement(['renda', 'investimento', 'despesa', 'gasto']) : null;
            }
        ];
    }
}
