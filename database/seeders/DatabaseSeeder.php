<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LaratrustSeeder::class,
            TahunPelajaranSeeder::class,
            SemesterSeeder::class,
            KelompokMapelSeeder::class,
            MataPelajaranSeeder::class,
            JurusanSeeder::class,
            LevelSeeder::class,
            EkstrakurikulerSeeder::class,
            LevelGuruSeeder::class,
            JenisUjianSeeder::class,
            SesiSeeder::class,
            RuangSeeder::class,
            KopKartuSeeder::class,
            KopAbsensiSeeder::class,
            ProfileSekolahSeeder::class,
            RunningTextSeeder::class,
            RaportAdminSettingSeeder::class,
            FormatNomorPesertaSeeder::class,

            // AdministratorSeeder::class,
            // UserAndSiswaSeeder::class,
        ]);
    }
}
