<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\YarnMaterial;
use App\Models\Fabric;
use App\Models\ProductionOrder;
use App\Models\ProductionReport;
use App\Models\ProductionReportDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users (Admin, Manager, Operators)
        // Ensure we strictly have specific roles
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        if (!User::where('email', 'manager@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Production Manager',
                'email' => 'manager@example.com',
                'password' => bcrypt('password'),
                'role' => 'manager',
            ]);
        }

        if (!User::where('email', 'supervisor@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Site Supervisor',
                'email' => 'supervisor@example.com',
                'password' => bcrypt('password'),
                'role' => 'supervisor',
            ]);
        }

        // Create 5 Operators
        User::factory(5)->create(['role' => 'operator']);

        // 2. Create Yarn Materials (Raw Materials)
        $yarns = YarnMaterial::factory(10)->create();

        // 3. Create Fabrics (Patterns/Result)
        // Fabric depends on Yarn
        Fabric::factory(5)->create();

        // 4. Create Production Orders
        ProductionOrder::factory(5)->create();

        // 5. Create Daily Reports (Operator Logs)
        // Each report has 1-3 details (rolls produced)
        ProductionReport::factory(10)->create()->each(function ($report) use ($yarns) {
            ProductionReportDetail::factory(rand(1, 3))->create([
                'production_report_id' => $report->id,
                'yarn_material_id' => $yarns->random()->id, // Pick from existing yarns
            ]);
        });

        // 6. Create Instructions
        $this->call(InstructionSeeder::class);
    }
}
