<?php

namespace App\Models;

use App\Enums\AdType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Ads extends Model
{
    use HasFactory ,Sluggable;
    protected $guarded = [];
     
    // protected $casts = [
    //     'type' =>AdType::class
    // ];
    protected $fillable = ['title', 'type', 'user_id', 'name', 'company_id','entitle','status','job_category_id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
     public function user(){
         return $this->belongsTo(User::class);
     }
     public function userSaved(){
        return $this->belongsToMany(User::class,'ads_user','ads_id','user_id','id','id');
    }
    public function personal()
    {
        return $this->hasOne(PersonalData::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable', 'imageable_type', 'imageable_id');
    }
    public function video()
    {
        return $this->morphOne(Video::class, 'videoable', 'videoable_type', 'videoable_id');
    }
    // public function jobCategories()
    // {
    //     return $this->morphToMany(JobCategory::class, 'job_categorizable', 'job_categorizable',  'job_categorizable_id', 'job_category_id', 'id', 'id', false);
    // }
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }
    public function degrees()
    {
        return $this->hasMany(Degree::class);
    }
    public function socials()
    {
        return $this->hasMany(Social::class);
    }
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
    public function langExperts()
    {
        return $this->hasMany(LangExpert::class);
    }
    public function softExperts()
    {
        return $this->hasMany(SoftExpert::class);
    }
    public function samples()
    {
        return $this->hasMany(Sample::class);
    }
}
