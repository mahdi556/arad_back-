<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecievedResume extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['ads_id', 'sender_id', 'reciever_id', 'type', 'resume_id'];


    public function ad()
    {
        return $this->belongsTo(Ads::class, 'ads_id', 'id');
    }
    public function resume()
    {
        return $this->belongsTo(Ads::class, 'resume_id', 'id');
    }
}
