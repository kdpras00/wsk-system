<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instruction;
use App\Models\User;

class InstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::where('role', 'manager')->first();

        if ($manager) {
            Instruction::create([
                'title' => 'Shift Malam Dipercepat',
                'description' => 'Mulai minggu depan, shift malam dimulai pukul 21:00 WIB. Mohon Operator menyesuaikan jadwal kehadiran.',
                'target_role' => 'operator',
                'user_id' => $manager->id,
            ]);

            Instruction::create([
                'title' => 'Maintenance Mesin #4',
                'description' => 'Mesin #4 akan menjalani maintenance pada hari Selasa. Jangan jadwalkan produksi berat di mesin tersebut.',
                'target_role' => 'supervisor',
                'user_id' => $manager->id,
            ]);

             Instruction::create([
                'title' => 'Audit Keamanan Bulanan',
                'description' => 'Persiapkan semua laporan keamanan untuk audit bulanan pada tanggal 28.',
                'target_role' => 'all',
                'user_id' => $manager->id,
            ]);
        }
    }
}
