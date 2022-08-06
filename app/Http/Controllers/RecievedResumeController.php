<?php

namespace App\Http\Controllers;

use App\Http\Resources\EAdsResource;
use App\Http\Resources\RAdsResource;
use App\Http\Resources\RecievedResumeResource;
use App\Models\Ads;
use App\Models\File;
use App\Models\RecievedResume;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecievedResumeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = RecievedResume::where('reciever_id', auth()->user()->id)->get();
        return $this->successResponse([
            'resumes' => RecievedResumeResource::collection($res->load('ad')->load('resume')),
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
        if ($request->type === 'site') {
            $resume = Ads::where('type', 're')->where('user_id', auth()->user()->id)->first();
            if (!$resume) {
                return response()->json(['message' => 'شما هنوز رزومه ای ایجاد نکرده اید'], 503);
            }
        }
        $ad = Ads::find($request->ad_id);
        $resume = RecievedResume::create([
            'sender_id' => $request->sender_id,
            'reciever_id' => $request->reciever_id,
            'ads_id' => $request->ad_id,
            'type' => $request->type,
            'resume_id' => $request->type === 'site' ? $resume->id : null

        ]);
        if ($request->hasFile('file')) {
            $imageName = Carbon::now()->microsecond . '.' . $request->file->extension();
            $request->file->storeAs('images/resume', $imageName, 'public');
            $file = File::create([
                'ads_id' => $request->ad_id,
                'file' => $imageName,
                'sender_id'=>$request->sender_id,
            ]);
        }
        return response('ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecievedResume  $recievedResume
     * @return \Illuminate\Http\Response
     */
    public function show(RecievedResume $recievedResume)
    {
        //
    }
    public function getMySentResumes()
    {
        // $resumes = RecievedResume::where('sender_id', auth()->user()->id)->pluck('ads_id');
        $resumes = RecievedResume::where('sender_id', auth()->user()->id)->get();
        // $ads = Ads::whereIn('id',$resumes)->get();

        return $this->successResponse([
            'ads' => RecievedResumeResource::collection($resumes->load('ad')),
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecievedResume  $recievedResume
     * @return \Illuminate\Http\Response
     */
    public function edit(RecievedResume $recievedResume)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RecievedResume  $recievedResume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecievedResume $recievedResume)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecievedResume  $recievedResume
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecievedResume $recievedResume)
    {
        //
    }
}
