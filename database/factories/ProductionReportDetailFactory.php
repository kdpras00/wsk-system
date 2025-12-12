<?php

namespace Database\Factories;

use App\Models\YarnMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductionReportDetail>
 */
class ProductionReportDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shifts = ['Pagi (07:00 - 15:00)', 'Sore (15:00 - 23:00)', 'Malam (23:00 - 07:00)'];
        $problems = ['Benang sering putus', 'Jarum patah', 'Tegangan tidak stabil', 'Kain bolong', null, null, null]; // More nulls as problems are occasional
        
        $yarn = YarnMaterial::inRandomOrder()->first() ?? YarnMaterial::factory()->create();

        return [
            'shift_name' => $this->faker->randomElement($shifts),
            'jam' => $this->faker->time('H:i'),
            'operator_name' => $this->faker->name(),
            'yarn_material_id' => $yarn->id,
            'pattern' => $yarn->pattern ?? 'Jersey Plain',
            
            // Production Metrics
            'counter_start' => 0,
            'counter_end' => 0, // Not used much in UI but required in DB
            'meter_count' => $this->faker->numberBetween(50, 200),
            'pcs_count' => 1,
            'no_pcs' => strtoupper($this->faker->bothify('##??')), // e.g. 01AB
            'grade' => $this->faker->randomElement(['A', 'A', 'A', 'B', 'C', 'BS']), // Mostly A
            
            // Usage
            'usage_qty' => $this->faker->randomFloat(2, 10, 25), // 10-25kg per roll
            'kg_count' => $this->faker->randomFloat(2, 10, 25),
            
            // Issues
            'posisi_benang_putus' => $this->faker->randomElement(['Bar I', 'Bar II', 'Bar III', 'Feeder 1', 'Feeder 5', '-']),
            'kode_masalah' => $this->faker->randomElement(['M-01', 'M-02', 'L-05', '-']),
            'comment' => $this->faker->randomElement($problems), // Logika: Jika kalimat ya kalimat
        ];
    }
}
