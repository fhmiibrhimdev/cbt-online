<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    protected $firstNames = [
        'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gita', 'Hadi', 'Indra', 'Joko',
        'Kirana', 'Lia', 'Maya', 'Nina', 'Oka', 'Putra', 'Rani', 'Sari', 'Tari', 'Udin',
        'Vina', 'Wati', 'Xena', 'Yuni', 'Zul', 'Arif', 'Bayu', 'Cahya', 'Dian', 'Endah',
        'Fahmi', 'Gilang', 'Hendra', 'Intan', 'Jaya', 'Kartika', 'Lutfi', 'Mutiara', 'Nadia', 'Oscar',
        'Pratama', 'Qori', 'Rizki', 'Sinta', 'Taufik', 'Umar', 'Vita', 'Wawan', 'Xander', 'Yosep', 'Zaki'
    ];

    protected $middleNames = [
        'Adit', 'Nugroho', 'Santoso', 'Wibowo', 'Ningrum', 'Sari', 'Susilo', 'Lestari', 'Dewi', 'Yuliana',
        'Baskara', 'Cahyadi', 'Darmawan', 'Ernawati', 'Farhan', 'Guntur', 'Hariyadi', 'Iskandar', 'Juwita', 'Kartini'
    ];

    protected $lastNames = [
        'Susanto', 'Pratama', 'Putri', 'Wulandari', 'Sari', 'Rahmawati', 'Halim', 'Kusuma', 'Larasati', 'Handayani',
        'Wirawan', 'Syahputra', 'Hakim', 'Gunawan', 'Suryani', 'Nugraha', 'Wardani', 'Saputra', 'Wahyuni', 'Hermanto'
    ];

    public function definition()
    {
        $nisn = $this->faker->unique()->numerify('##########'); // 10 digit angka

        $firstName = $this->faker->randomElement($this->firstNames);
        $middleName = $this->faker->optional()->randomElement($this->middleNames); // Middle name is optional
        $lastName = $this->faker->randomElement($this->lastNames);

        $fullName = $firstName;
        if ($middleName) {
            $fullName .= ' ' . $middleName;
        }
        $fullName .= ' ' . $lastName;

        $user = User::factory()
            ->withName($fullName)
            ->withEmail($nisn . '@cbt')
            ->withRole('siswa') // Menambahkan role 'siswa'
            ->create();

        return [
            'id_user'     => $user->id, // Assign the created user's ID
            'nama_siswa'  => $fullName,
            'nis'         => $this->faker->unique()->numerify('#####'), // 5 digit angka
            'nisn'        => $nisn, // Use the generated 'nisn'
            'jk'          => $this->faker->randomElement(['L', 'P']),
            'kelas'       => $this->faker->word,
            'tahun_masuk' => $this->faker->year,
            'tgl_lahir'   => $this->faker->date,
        ];
    }
}
