<?php
namespace Database\Factories;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'rol_id' => Rol::factory(),
            'nombres' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'cedula' => $this->faker->unique()->numerify('########'),
            'correo' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'estado' => 1,
        ];
    }
}
