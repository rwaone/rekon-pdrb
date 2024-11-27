<?php

namespace App\Models;

use App\Models\Subsector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classification extends Model
{
    use HasFactory;

    protected $load = ['subsectors'];
    
    public function subsectors()
    {
        return $this->hasMany(Subsector::class);
    }
}
