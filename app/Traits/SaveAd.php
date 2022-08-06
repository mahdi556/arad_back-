<?php

namespace App\Traits;

use App\Models\Ads;
use App\Models\Degree;
use App\Models\Experience;
use App\Models\LangExpert;
use App\Models\Sample;
use App\Models\Social;
use App\Models\SoftExpert;

trait SaveAd
{
    protected function SaveHandler($request, $ad_id)
    {
        $ad = Ads::find($ad_id);
        $personal = $ad->personal()->create([
            'ads_id' => $ad_id,
            'company_name' => $request->data['companyName'],
            'company_id' => $request->data['companyId'],
            'fa_name' => $request->data['name'],
            'fa_last_name' => $request->data['lastname'],
            'en_name' => $request->data['Ename'],
            'en_last_name' => $request->data['Elastname'],
            'whatsapp' => $request->data['whatsapp'],
            'telegram' => $request->data['telegram'],
            'cellphone' => $request->data['cellphone'],
            'email' => $request->data['email'],
            'sex' => $request->data['sex']['id'],
            'city_id' => $request->data['city']['id'],
            'province_id' => $request->data['province']['id'],
            'fa_salary_from' => $request->data['salary']['fa']['from'],
            'fa_salary_to' => $request->data['salary']['fa']['to'],
            'en_salary_from' => $request->data['salary']['en']['from'],
            'en_salary_to' => $request->data['salary']['en']['to'],
            'salary_type' => $request->data['salaryType']['id'],
            'insurrance' => $request->data['insurrance'],
            'military' => $request->data['military'],
            'married' => $request->data['married'],
            'description' => $request->data['description'],
            'fa_work_hour_from' => $request->data['workHour']['fa']['from'],
            'fa_work_hour_to' => $request->data['workHour']['fa']['to'],
            'corporate_time' => $request->data['corporateTime']['id'],
            'corporate_type' => $request->data['corporateType'],
            'fa_age_range_from' => $request->data['ageRange']['fa']['from'],
            'fa_age_range_to' => $request->data['ageRange']['fa']['to'],
            'fa_birth_d' => $request->data['birthday']['day'],
            'fa_birth_m' => $request->data['birthday']['month'],
            'fa_birth_y' => $request->data['birthday']['year'],
            'en_birth_d' => $request->data['Ebirthday']['day'],
            'en_birth_m' => $request->data['Ebirthday']['month'],
            'en_birth_y' => $request->data['Ebirthday']['year'],
            'travel' => $request->data['travel'],
        ]);
        if ($ad->type == 'ev' || $ad->type == 'rv' || $ad->type == 're') {
            for ($i = 0; $i < count($request->data['degree']); $i++) {
                Degree::create([
                    'ads_id' => $ad->id,
                    'fa_name' => $request->data['degree'][$i]['title'],
                    'fa_major' => $request->data['degree'][$i]['degree'],
                    'fa_active' => $request->data['degree'][$i]['active'],
                    'fa_date_d' => $request->data['degree'][$i]['date']['d'],
                    'fa_date_m' => $request->data['degree'][$i]['date']['m'],
                    'fa_date_y' => $request->data['degree'][$i]['date']['y'],
                    'en_name' => $request->data['degree'][$i]['Entitle'],
                    'en_major' => $request->data['degree'][$i]['Endegree'],
                    'en_active' => $request->data['degree'][$i]['Enactive'],
                    'en_date_d' => $request->data['degree'][$i]['Endate']['d'],
                    'en_date_m' => $request->data['degree'][$i]['Endate']['m'],
                    'en_date_y' => $request->data['degree'][$i]['Endate']['y'],
                ]);
            }
            for ($i = 0; $i < count($request->data['experiences']); $i++) {
                Experience::create([
                    'ads_id' => $ad->id,
                    'fa_title' => $request->data['experiences'][$i]['title'],
                    'fa_org' => $request->data['experiences'][$i]['name'],
                    'fa_reason' => $request->data['experiences'][$i]['reason'],
                    'fa_start_m' => $request->data['experiences'][$i]['start']['m'],
                    'fa_start_y' => $request->data['experiences'][$i]['start']['y'],
                    'fa_finish_m' => $request->data['experiences'][$i]['finish']['m'],
                    'fa_finish_y' => $request->data['experiences'][$i]['finish']['y'],
                    'en_title' => $request->data['experiences'][$i]['Entitle'],
                    'en_org' => $request->data['experiences'][$i]['Enname'],
                    'en_reason' => $request->data['experiences'][$i]['Enreason'],
                    'en_start_m' => $request->data['experiences'][$i]['Enstart']['m'],
                    'en_start_y' => $request->data['experiences'][$i]['Enstart']['y'],
                ]);
            }
            for ($i = 0; $i < count($request->data['langExpert']); $i++) {
                LangExpert::create([
                    'ads_id' => $ad->id,
                    'fa_name' => $request->data['langExpert'][$i]['text'],
                    // 'en_name' => $request->data['langExpert'][$i]['text'],
                    'level' => $request->data['langExpert'][$i]['level']['id'],

                ]);
            }
            for ($i = 0; $i < count($request->data['softExpert']); $i++) {
                SoftExpert::create([
                    'ads_id' => $ad->id,
                    'fa_name' => $request->data['softExpert'][$i]['text'],
                    // 'en_name' => $request->data['softExpert'][$i]['text'],
                    'level' => $request->data['softExpert'][$i]['level']['id'],

                ]);
            }
            if ($ad->type == 'ev'   || $ad->type == 're') {
                for ($i = 0; $i < count($request->data['socials']); $i++) {
                    Social::create([
                        'ads_id' => $ad->id,
                        'name' => $request->data['socials'][$i]['name'],
                        'address' => $request->data['socials'][$i]['address'],
                    ]);
                }
                for ($i = 0; $i < count($request->data['other_socials']); $i++) {
                    Social::create([
                        'ads_id' => $ad->id,
                        'name' => $request->data['other_socials'][$i]['name'],
                        'address' => $request->data['other_socials'][$i]['address'],
                    ]);
                }
            }
            for ($i = 0; $i < count($request->data['sampleEx']); $i++) {
                Sample::create([
                    'ads_id' => $ad->id,
                    'fa_name' => $request->data['sampleEx'][$i]['title'],
                    'link' => $request->data['sampleEx'][$i]['link'],
                    'fa_discription' => $request->data['sampleEx'][$i]['faDiscription'],
                    'en_name' => $request->data['sampleEx'][$i]['Entitle'],
                    'en_discription' => $request->data['sampleEx'][$i]['enDiscription'],
                    'ucode' => $request->data['sampleEx'][$i]['ucode'],
                ]);
            }
        }
    }
}
