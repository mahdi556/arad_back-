<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.type'=>['required',Rule::in(['ev','en','rv','rn','re'])],
            'data.job_category_id' =>'required|integer',
            'data.title'=>'required|string',
            'data.companyName' => 'required|string',
            'data.companyId' => 'string',
            'data.name' => 'string',
            'data.lastname' => 'string',
            'data.Ename' => 'string',
            'data.Elastname' => 'string',
            'data.whatsapp' => 'string',
            'data.telegram' =>'string',
            'data.cellphone' => 'string',
            'data.email' => 'email',
            'data.sex.id' => ['required'],
            'data.city.id' => 'required|integer',
            'data.province.id' => 'required|integer',
            'data.salary.fa.from' =>  'integer',
            'data.salary.fa.from' =>  'integer',
            'data.salary.en.from' =>  'integer',
            'data.salary.en.to' => 'integer',
            'data.salaryType.id' => 'integer',
            'data.insurrance' => 'integer',
            'data.military' => 'integer',
            'data.married' => 'required|integer',
            'data.description' =>'required|string',
            'data.workHour.fa.from' => 'integer',
            'data.workHour.fa.to' =>'integer',
            'data.corporateTime.id' => 'integer',
            'data.corporateType' => 'integer',
            'data.ageRange.fa.from' => 'integer',
            'data.ageRange.fa.to' => 'integer',
            'data.birthday.day' => 'integer',
            'data.birthday.month' => 'integer',
            'data.birthday.year' => 'integer',
            'data.Ebirthday.day' => 'integer',
            'data.Ebirthday.month' => 'integer',
            'data.Ebirthday.year' =>'integer',
            'data.travel' => 'integer',
              
        ];
    }
}
