<?php

namespace App\Http\Controllers;

use App\Enums\AdType;
use App\Http\Requests\AdRequest;
use App\Http\Resources\AdsResource;
use App\Http\Resources\EAdsResource;
use App\Http\Resources\RAdsResource;
use App\Http\Resources\ResumeResource;
use App\Models\Ads;
use App\Models\City;
use App\Models\Degree;
use App\Models\Experience;
use App\Models\JobCategory;
use App\Models\LangExpert;
use App\Models\Sample;
use App\Models\Social;
use App\Models\SoftExpert;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use App\Traits\SaveAd;

class AdsController extends ApiController
{
    use SaveAd;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eads = Ads::whereIn('type', ['ev', 'en'])->get();
        $rads = Ads::whereIn('type', ['rv', 'rn'])->get();

        return $this->successResponse([
            'eads' => EAdsResource::collection($eads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('softExperts')),
            'rads' => RAdsResource::collection($rads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('langExperts'))
        ], 200);
    }
    public function mainPageAds()
    {
        $eads = Ads::whereIn('type', ['ev', 'en'])->orderBy('id', 'desc')->take(10)->get();
        $rads = Ads::whereIn('type', ['rv', 'rn'])->orderBy('id', 'desc')->take(10)->get();

        return $this->successResponse([
            'eads' => EAdsResource::collection($eads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('softExperts')),
            'rads' => RAdsResource::collection($rads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('langExperts'))
        ], 200);
    }
    public function getEmployerAds(Request $request)
    {
        $eads = Ads::where('user_id', auth()->user()->id)->whereIn('type', ['rv', 'rn'])->get();

        return $this->successResponse([
            'rads' => RAdsResource::collection($eads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('softExperts')),
        ], 200);
    }
    public function  adList(Request $request)
    {
        $type = $request->type == 'employee' ? ['ev', 'en'] : ['rv', 'rn'];
        $eads = Ads::whereIn('type', $type)->orderByDesc('id')->paginate(24);
        // return response($type);
        return $this->successResponse([
            'eads' => EAdsResource::collection($eads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('softExperts')),
            'links' =>  EAdsResource::collection($eads)->response()->getData()->links,
            'meta' =>  EAdsResource::collection($eads)->response()->getData()->meta,
        ], 200);
        // return response($eads,200);
    }
    public function  getSearched(Request $request)
    {
        $type = $request->type == 'employee' ? ['ev,en'] : ['rv,rn'];
        $local = $request->local_id;
        $cat = $request->cat_id;
        $params = $request->params;
        // $isExperience = $params['experience'] ? 'whereHas' : 'whereDoesntHave';
        $experience = $params['experience'] ? 'experiences' : 'personal';
        $isVip = $params['vip'] ? ['ev', 'rv'] : ['ev', 'rv', 'en', 'rn'];
        // return response($request);
        $eads = Ads::
            // whereIn('type', $type)->
            with(['personal', 'jobCategory', 'experiences'])
            ->whereHas('personal', function ($q) use ($local) {
                // Query the name field in status table
                $local != 0 && $q->where('province_id',  $local); // '=' is optional
            })->whereHas('jobCategory', function ($q) use ($cat) {
                // Query the name field in status table
                $cat != 0 && $q->where('job_category_id', $cat); // '=' is optional
            })
            ->whereHas('personal', function ($q) use ($params) {
                $params['ins'] != 0 && $q->where('insurrance', $params['ins']);
            })
            ->whereHas('personal', function ($q) use ($params) {
                $params['military'] != 0 && $q->where('military', $params['military']);
            })
            ->whereHas('personal', function ($q) use ($params) {
                $params['agreeType']['status'] != 0 && $q->where('corporate_type', $params['agreeType']['value']);
            })
            ->whereHas('personal', function ($q) use ($params) {
                $params['agreeTime']['status'] != 0 && $q->where('corporate_time', $params['agreeTime']['value']);
            })
            ->whereHas('personal', function ($q) use ($params) {
                $params['sex']['status'] != 0 && $q->where('sex', $params['sex']['value']);
            })
            ->whereHas('personal', function ($q) use ($params) {
                $params['salary']['status'] != 0 && $q->where('fa_salary_from', '>', $params['salary']['min'])->where('fa_salary_to', '<', $params['salary']['max']);
            })
            ->whereHas('personal', function ($q) use ($params) {
                $params['age']['status'] != 0 && $q->where('fa_age_range_from', '>', $params['age']['min'])->where('fa_age_range_to', '<', $params['age']['max']);
            })
            ->whereIn('type', $isVip)
            ->whereHas($experience)
            ->orderByDesc('id')->paginate(24);

        return $this->successResponse([
            'eads' => EAdsResource::collection($eads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('softExperts')),
            'links' =>  EAdsResource::collection($eads)->response()->getData()->links,
            'meta' =>  EAdsResource::collection($eads)->response()->getData()->meta,
        ], 200);
        return response($eads, 200);
    }

    /**
     * Show the form for creating a new resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function getEditableAd(Request $request)
    {

        $ad = Ads::find($request->ad_id);
        if (!$ad) {
            return response()->json(['message' => ' no resume']);
        }
        return $this->successResponse([
            'ad' => new ResumeResource($ad->load('personal')->load('jobCategory')->load('experiences')->load('user')
                ->load('langExperts')->load('softExperts')->load('degrees')->load('samples')->load('socials'))
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    public function storeAd(AdRequest $request)

    {

        DB::beginTransaction();
        $ad = Ads::create([
            'user_id' => auth()->user()->id,
            'type' => $request->data['type'],
            'title' => $request->data['title'],
            'entitle' => $request->data['entitle'],
            'job_category_id' => $request->data['jobCategory']['id']
        ]);
        $ad->save();
        $this->SaveHandler($request, $ad->id);
        DB::commit();
        return response()->json(['message' => 'registered successfully', 'ad_id' => $ad->id], 200);
    }

    public function update(AdRequest $request)
    {
        $ad = Ads::find($request->data['ad_id']);
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

        return response()->json(['message' => 'registered successfully', 'ad_id' => $ad->id], 200);
    }

    public function store_media(Request $request)
    {
        DB::beginTransaction();
        $ad = Ads::find($request->ad_id);
        if ($request->hasFile('image')) {
            $imageName = Carbon::now()->microsecond . '.' . $request->image->extension();
            $request->image->storeAs('images/users', $imageName, 'public');
            $image = $ad->image()->create([
                'url' => $imageName
            ]);
        } else {

            $image = $ad->image()->create([
                'url' => '127568.jpg'
            ]);
        }
        if ($request->hasFile('video')) {
            $imageName = Carbon::now()->microsecond . '.' . $request->video->extension();
            $request->video->storeAs('videos/users', $imageName, 'public');
            $image = $ad->video()->create([
                'url' => $imageName
            ]);
        } else {

            $image = $ad->video()->create([
                'url' => '127568.jpg'
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            // return response('file');
            if ($request->hasFile('sample' . $i)) {
                $name = 'sample' . $i;
                $fileName = Carbon::now()->microsecond . '.' . $request->$name->extension();
                $request->$name->storeAs('samples', $fileName, 'public');
                $samaple = Sample::where('ads_id', $ad->id)->where('ucode', '!=', NULL)->where('file', NULL)->first();
                $samaple->file = $fileName;
                $samaple->save();
            }
        }
        DB::commit();
        return response()->json(['message' => 'registered successfully'], 200);
    }

    public function update_media(Request $request)
    {
        DB::beginTransaction();
        $ad = Ads::find($request->ad_id);
        $ad->video()->delete();
        if ($request->hasFile('image')) {
            $ad->image()->delete();
            $imageName = Carbon::now()->microsecond . '.' . $request->image->extension();
            $request->image->storeAs('images/users', $imageName, 'public');
            $image = $ad->image()->create([
                'url' => $imageName
            ]);
        } else {

            $image = $ad->image()->create([
                'url' => '127568.jpg'
            ]);
        }
        if ($request->hasFile('video')) {
            $imageName = Carbon::now()->microsecond . '.' . $request->video->extension();
            $request->video->storeAs('videos/users', $imageName, 'public');
            $image = $ad->video()->create([
                'url' => $imageName
            ]);
        } else {

            $image = $ad->video()->create([
                'url' => '127568.jpg'
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            if ($request->hasFile('sample' . $i)) {
                $name = 'sample' . $i;
                $fileName = Carbon::now()->microsecond . '.' . $request->$name->extension();
                $request->$name->storeAs('samples', $fileName, 'public');
                $samaple = Sample::where('ads_id', $ad->id)->where('ucode', '!=', NULL)->where('file', NULL)->first();
                $samaple->file = $fileName;
                $samaple->save();
            }
        }
        DB::commit();
        return response()->json(['message' => 'registered successfully'], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ads  $ads
     * @return \Illuminate\Http\Response
     */


    public function show(Ads $ad)
    {
        return $this->successResponse([
            'ad' => new EAdsResource($ad->load('personal')->load('jobCategory')->load('experiences')->load('user')->load('langExperts')->load('softExperts')->load('degrees')->load('samples'))
        ], 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function storeSaveAd(Ads $ad)
    {
        $user = User::find(auth()->user()->id);
        // $ad = Ads::find($request->ad_id);
        $saved = $user->savedAds->where('id', $ad->id)->first();
        if ($saved) {
            $result = $user->savedAds()->detach($ad);
            return $this->successResponse( 'آگهی با موفقیت از حالت ذخیره خارج شد', 200);
        } else {
            $result = $user->savedAds()->attach($ad);
            return $this->successResponse( 'آگهی با موفقیت  ذخیره شد', 200);
        }
    }
    public function edit(Ads $ads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ads  $ads
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ads $ads)
    {
        //
    }
}
