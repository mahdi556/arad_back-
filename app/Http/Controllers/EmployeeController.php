<?php

namespace App\Http\Controllers;

use App\Http\Resources\RAdsResource;
use App\Models\Ads;
use App\Models\Employee;
use App\Models\PersonalData;
use Illuminate\Http\Request;

class EmployeeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getmyEmployeeAds()
    {
        $ads = Ads::where('user_id', auth()->user()->id)->get();
        return $this->successResponse([
            'eads' => RAdsResource::collection($ads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('softExperts')),
        ], 200);
    }

    public function SuggestAds()
    {
        $ads1 = auth()->user()->savedAds->pluck('job_category_id');

        $ads2 = Ads::where('user_id', auth()->user()->id)->pluck('job_category_id');
        $ads = $ads1->merge($ads2);
        $suggests = Ads::whereIn('job_category_id', $ads)->whereIn('type', ['rn','rv'])->get();

        return $this->successResponse([
            'rads' => RAdsResource::collection($suggests->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('langExperts'))
        ], 200);
    }

    public function SavedAds()
    {
        $ads = auth()->user()->savedAds;
        return $this->successResponse([
            'rads' => RAdsResource::collection($ads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('langExperts'))
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
