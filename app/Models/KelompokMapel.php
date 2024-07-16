<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMapel extends Model
{
    use HasFactory;
    protected $table = "kelompok_mapel";
    protected $guarded = [];
    
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo(KelompokMapel::class, 'id_parent', 'id');
    }

    // Define the relationship to the children
    public function children()
    {
        return $this->hasMany(KelompokMapel::class, 'id_parent', 'id');
    }
}
