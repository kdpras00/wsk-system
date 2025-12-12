<?php

namespace Database\Factories;

use App\Models\YarnMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fabric>
 */
class FabricFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patterns = ['Jersey Plain', 'Baby Terry', 'Fleece', 'Lacoste Pique', 'Rib 1x1', 'Interlock'];
        
        return [
            'pattern' => $this->faker->randomElement($patterns),
            'yarn_material_id' => YarnMaterial::inRandomOrder()->first()->id ?? YarnMaterial::factory(),
            'meter' => $this->faker->randomFloat(2, 10, 50),
            'jam' => $this->faker->time('H:i'),
            'no_pcs' => strtoupper($this->faker->bothify('PCS-####')),
            'stok_kg' => $this->faker->randomFloat(2, 5, 25),
            'keterangan' => $this->faker->sentence(6), // "Jika kalimat ya kalimat"
        ];
    }
}
