<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class period extends Model
{
    use HasFactory;
 
    protected $guarded = ['id'];

    protected $load = ['pdrb'];
    
    public function pdrb()
    {
        return $this->hasMany(Pdrb::class);
    }
}
