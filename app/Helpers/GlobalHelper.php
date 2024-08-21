<?php

namespace App\Helpers;

use App\Models\TahunPelajaran;
use App\Models\Semester;

class GlobalHelper
{
    public static function getActiveTahunPelajaranId()
    {
        return TahunPelajaran::where('active', '1')->first()->id ?? null;
    }

    public static function getActiveSemesterId()
    {
        return Semester::where('active', '1')->first()->id ?? null;
    }
}
