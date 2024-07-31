<?php

namespace Database\Seeders;

use App\Models\RunningText;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RunningTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'text' => '',
            ],
            [
                'text' => '',
            ],
            [
                'text' => '',
            ],
            [
                'text' => '',
            ],
            [
                'text' => '',
            ],
        ];

        RunningText::insert($data);
    }
}
