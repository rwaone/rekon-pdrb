<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdrb extends Model
{
    use HasFactory;
 
    protected $guarded = ['id'];

    protected $with = ['region', 'period', 'subsector'];
    protected $load = ['adjustment'];
   
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function subsector()
    {
        return $this->belongsTo(Subsector::class);
    }

    public function adjustment()
    {
        return $this->hasOne(Adjustment::class);
    }
}
