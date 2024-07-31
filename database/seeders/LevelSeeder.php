<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i < 14; $i++) {
            $data[] = [
                'level' => $this->toRoman($i),
            ];
        }

        Level::insert($data);
    }

    function toRoman($num) 
    {
        $n = intval($num);
        $result = '';

        $lookup = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 
                'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 
                'V' => 5, 'IV' => 4, 'I' => 1];

        foreach ($lookup as $roman => $value) {
            $matches = intval($n / $value);
            $result .= str_repeat($roman, $matches);
            $n = $n % $value;
        }

        return $result;
    }
}
