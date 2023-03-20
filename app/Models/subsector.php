<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subsector extends Model
{
    use HasFactory;
    
    public function Sector()
    {
        return $this->belongsTo(Sector::class);
    }
    
    public function pdrb()
    {
        return $this->hasMany(Pdrb::class);
    }
}
