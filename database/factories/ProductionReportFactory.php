<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductionReport>
 */
class ProductionReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Operator is usually role 'operator'
            'user_id' => User::where('role', 'operator')->inRandomOrder()->first()->id ?? User::factory()->state(['role' => 'operator']),
            'machine_name' => 'Mesin ' . $this->faker->numberBetween(1, 10), // "Huruf ya Huruf & Angka"
            'production_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'notes' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
        ];
    }
}
