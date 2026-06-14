<?php
namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'categoria_id' => Categoria::factory(),
            'marca' => $this->faker->randomElement(['Samsung', 'Apple', 'Xiaomi']),
            'nombre' => $this->faker->word() . ' ' . $this->faker->word(),
            'precio' => $this->faker->randomFloat(0, 100000, 5000000),
            'stock' => $this->faker->numberBetween(0, 50),
            'tipo' => 'nuevo',
            'estado' => 1,
        ];
    }
}
