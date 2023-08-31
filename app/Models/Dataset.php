<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    
    protected $with = ['region', 'period'];

    protected $load = ['dataset'];
    
    public function pdrb()
    {
        return $this->hasMany(Pdrb::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    
    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
