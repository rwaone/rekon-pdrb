<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
 
    protected $guarded = ['id'];

    protected $load = ['dataset'];
    
    public function dataset()
    {
        return $this->hasMany(Dataset::class);
    }
}
