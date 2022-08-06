<?php

namespace App\Models;

use App\Enums\InsurranceStatus;
use App\Enums\MarriedType;
use App\Enums\SexTyp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalData extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='personal_data';
    // protected $casts=[
    //     'insurrance'=>InsurranceStatus::class,
    //     // 'sex'=>SexType::class,
    //     'mrarried'=>MarriedType::class
    // ];
   
    public function personal(){
        return $this->belongsTo(Ads::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
