<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YarnMaterial>
 */
class YarnMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Cotton 100%', 'Polyester', 'Rayon', 'TC (Tetoron Cotton)', 'CVC', 'Spandex'];
        $names = [
            'Combed 30s', 'Combed 24s', 'Combed 20s', 
            'Carded 30s', 'PE 20s', 'PE 30s', 
            'Rayon Viscose', 'Spandex Lycra'
        ];
        $colors = ['Putih', 'Hitam', 'Merah Maroon', 'Biru Navy', 'Hijau Botol', 'Abu Misty', 'Kuning Mustard'];

        // Ensure "Huruf ya Huruf" -> Specific realistic names
        $name = $this->faker->randomElement($names); 
        $type = $this->faker->randomElement($types);
        $color = $this->faker->randomElement($colors);
        
        return [
            'name' => "{$type} - {$name}",
            'pattern' => $this->faker->optional(0.5)->randomElement(['Plain', 'Rib', 'Pique', 'Fleece']),
            'color' => $color,
            'type' => explode(' ', $type)[0], // e.g., 'Cotton'
            'batch_number' => 'BATCH-' . strtoupper($this->faker->bothify('##??#')),
            'stock_quantity' => $this->faker->randomFloat(2, 100, 5000), // 100 to 5000 kg
            'unit' => 'kg',
        ];
    }
}
