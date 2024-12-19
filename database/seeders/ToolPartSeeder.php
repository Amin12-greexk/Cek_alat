<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToolPart;

class ToolPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $parts = [
            [
                'tool_id' => 1, // Assuming tool_id = 1 for the example
                'part_name' => 'Panel Listrik',
                'description' => 'ELCB BISA BEKERJA DENGAN BAIK',
                'validation' => 'required|boolean',
            ],
            [
                'tool_id' => 1,
                'part_name' => 'Grounding',
                'description' => 'BAIK',
                'validation' => 'required|boolean',
            ],
            [
                'tool_id' => 1,
                'part_name' => 'Switch',
                'description' => 'BAIK',
                'validation' => 'required|boolean',
            ],
            [
                'tool_id' => 1,
                'part_name' => 'Pengunci Mata Bor',
                'description' => 'BAIK, TIDAK LONGGAR',
                'validation' => 'required|boolean',
            ],
            [
                'tool_id' => 1,
                'part_name' => 'Baut - Baut Pengikat',
                'description' => 'BAIK, TERPASANG KUAT',
                'validation' => 'required|boolean',
            ],
            [
                'tool_id' => 1,
                'part_name' => 'Kabel / Steker',
                'description' => 'SAMBUNGAN TERIKAT KUAT, DIISOLASI DENGAN BAIK MEMAKAI ISOLASI STANDAR DAN DILEWATKAN ATAS',
                'validation' => 'required|string',
            ],
            [
                'tool_id' => 1,
                'part_name' => 'Megger Test',
                'description' => 'BAIK',
                'validation' => 'required|boolean',
            ],
        ];

        foreach ($parts as $part) {
            ToolPart::create($part);
        }
    }
}
