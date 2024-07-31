<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportAdminSetting extends Model
{
    use HasFactory;
    protected $table = "raport_admin_setting";
    protected $guarded = [];

    public $timestamps = false;
}
