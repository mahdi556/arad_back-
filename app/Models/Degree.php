<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'degrees';

    public function ad()
    {
        return $this->belongsTo(Ads::class);
    }
}
