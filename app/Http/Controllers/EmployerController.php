<?php

namespace App\Http\Controllers;

use App\Http\Resources\EAdsResource;
use App\Http\Resources\RAdsResource;
use App\Models\Ads;
use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getmyEmployerAds()
    {
        $ads = Ads::where('user_id', auth()->user()->id)->get();
        return $this->successResponse([
            'rads' => RAdsResource::collection($ads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('softExperts')),
        ], 200);
    }

    public function SuggestAds()
    {
        $ads1 = auth()->user()->savedAds->pluck('job_category_id');
        $ads2 = Ads::where('user_id', auth()->user()->id)->pluck('job_category_id');
        $ads = $ads1->merge($ads2);
        $suggests = Ads::whereIn('job_category_id', $ads)->whereIn('type', ['ev', 'en', 're'])->get();

        return $this->successResponse([
            'rads' => EAdsResource::collection($suggests->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('langExperts'))
        ], 200);
    }

    public function SavedAds()
    {
        $ads = auth()->user()->savedAds;
        return $this->successResponse([
            'rads' => EAdsResource::collection($ads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('langExperts'))
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function show(Employer $employer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function edit(Employer $employer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employer $employer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employer  $employer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employer $employer)
    {
        //
    }
}
