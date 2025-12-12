<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductionOrder>
 */
class ProductionOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => 'PO-' . date('Y') . '-' . strtoupper($this->faker->unique()->bothify('####')),
            'manager_id' => User::where('role', 'manager')->inRandomOrder()->first()->id ?? User::factory()->state(['role' => 'manager']),
            'status' => $this->faker->randomElement(['Planned', 'In Progress', 'Completed']),
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end_date' => $this->faker->optional(0.7)->dateTimeBetween('now', '+1 month'),
        ];
    }
}
