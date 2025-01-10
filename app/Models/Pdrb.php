<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdrb extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['dataset', 'subsector', 'adjustment'];
    protected $load = ['adjustment'];


    public function dataset()
    {
        return $this->belongsTo(Dataset::class);
    }

    public function subsector()
    {
        return $this->belongsTo(Subsector::class);
    }

    public function adjustment()
    {
        return $this->hasOne(Adjustment::class);
    }

    public function category() {
        return $this->subsector->sector->category_id ?? null;
    }
}
