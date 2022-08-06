<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResumeResource;
use App\Models\Ads;
use App\Models\User;
use App\Traits\SaveAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumeController extends ApiController
{
    use SaveAd;

    public function storeRe(Request $request)
    {
        $ad = Ads::where('user_id', auth()->user()->id)->where('type', 're')->first();
        $user = User::find(auth()->user()->id);
        $user->update(['step' => $request->data['step']]);
        if ($ad) {

            try {
                DB::beginTransaction();
                $ad->update([
                    'user_id' => auth()->user()->id,
                    'type' => $request->data['type'],
                    'title' => $request->data['title'],
                    'entitle' => $request->data['entitle'],
                    'job_category_id' => $request->data['jobCategory']['id']
                ]);
                $ad->save();
                $ad->personal &&
                    $ad->personal->delete();
                $ad->degrees &&
                    $ad->degrees()->delete();
                $ad->socials &&
                    $ad->socials()->delete();
                $ad->experiences &&
                    $ad->experiences()->delete();
                $ad->langExperts &&
                    $ad->langExperts()->delete();
                $ad->softExperts &&
                    $ad->softExperts()->delete();
                $ad->samples &&
                    $ad->samples()->delete();
                $this->SaveHandler($request, $ad->id);
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                return response()->json(['errors' => $ex->getMessage()], 422);
            }
            return response()->json(['message' => 'registered successfully', 'ad_id' => $ad->id], 200);
        }
        try {
            DB::beginTransaction();

            $ad = Ads::create([
                // 'user_id' => auth()->user()->id,
                'user_id' => auth()->user()->id,
                'type' => $request->data['type'],
                'title' => $request->data['title'],
                'entitle' => $request->data['entitle'],
                'job_category_id' => $request->data['jobCategory']['id']

            ]);
            $ad->save();
            $this->SaveHandler($request, $ad->id);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['errors' => $ex->getMessage()], 422);
        }

        return response()->json(['message' => 'registered successfully', 'ad_id' => $ad->id], 200);
    }


    public function getResume(Request $request)
    {
        $user_id = $request->user_id;
        //    return response($user_id);

        $ad = Ads::where('user_id', auth()->user()->id)->where('type', 're')->first();
        if (!$ad) {
            return response()->json(['message' => ' رزومه ای ثبت نشده است'], 422);
        }
        return $this->successResponse([
            'ad' => new ResumeResource($ad->load('personal')->load('jobCategory')->load('experiences')->load('user')->load('langExperts')
                ->load('softExperts')->load('degrees')->load('samples')->load('socials'))
        ], 200);
    }
}
