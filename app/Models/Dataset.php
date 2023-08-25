<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    use HasFactory;
    
    protected $with = ['region', 'period'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    
    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
