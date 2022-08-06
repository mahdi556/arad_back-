<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'company_id' => $this->company_id,
            'fa_city' => $this->fa_city,
            'fa_province' => $this->fa_province,
            'fa_salary_from' => $this->fa_salary_from,
            'fa_salary_to' => $this->fa_salary_to,
            'en_salary_from' => $this->en_salary_from,
            'en_salary_to' => $this->en_salary_to,
            'salary_type' => $this->salary_type,
            'insurrance' => $this->insurrance,
            'married' => $this->married,
            'sex'=>$this->sex,
            'description' => $this->description,
            'fa_work_hour_from' => $this->fa_work_hour_from,
            'fa_work_hour_to' => $this->fa_work_hour_to,
            'en_work_hour_from' => $this->fa_work_hour_from,
            'en_work_hour_to' => $this->fa_work_hour_to,
            'corporate_time' => $this->corporate_time,
            'corporate_type' => $this->corporate_type,
            'fa_age_range_from' => $this->fa_age_range_from,
            'fa_age_range_to' => $this->fa_age_range_to,
            'city_fa' => $this->city->fa,
            'city_id' => $this->city_id,
            'province_id' => $this->province_id,
             'fa_birth_d' => $this->fa_birth_d,
            'fa_birth_m' => $this->fa_birth_m,
            'fa_birth_y' => $this->fa_birth_y,
            'en_birth_d' => $this->en_birth_d,
            'en_birth_m' => $this->en_birth_m,
            'en_birth_y' => $this->en_birth_y,
            'cellphone' => $this->cellphone,
            'whatsapp' => $this->whatsapp,
            'telegram' => $this->telegram,
            'email' => $this->email,
            'fa_name' => $this->fa_name,
            'fa_last_name' => $this->fa_last_name,
            'en_name' => $this->en_name,
            'en_last_name' => $this->en_last_name,
            'military' => $this->military,
            'travel' => $this->travel,



        ];
    }
}
