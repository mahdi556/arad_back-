<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function ad(){
        return $this->belongsTo(Ads::class);
    }
}
