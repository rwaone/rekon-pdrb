<?php

namespace App\Models;

use App\Models\Classification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subsector extends Model
{
    use HasFactory;
 
    protected $guarded = ['id'];
    
    public function Sector()
    {
        return $this->belongsTo(Sector::class);
    }
    
    public function Classification()
    {
        return $this->belongsTo(Classification::class);
    }
    
    public function pdrb()
    {
        return $this->hasMany(Pdrb::class);
    }
}
