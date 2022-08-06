<?php

namespace App\Http\Controllers;

use App\Models\AdView;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AdViewController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $ads_id = 194;
        // $date = jdate('today')->format(' %d/ %m /%y');
        $view = AdView::where('ads_id', $ads_id)->first();
        $date = Carbon::now()->addDays(0)->format('Y,m,d');
        if ($view) {
            $data = unserialize($view->days);
            $isDay = false;
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['date'] == $date) {
                    $data[$i]['qty'] = $data[$i]['qty'] + 1;
                    $isDay = true;
                }
            }
            if (!$isDay) {
                array_push($data, ['date' => $date, 'qty' => 0]);
            }
            $view->days = serialize($data);
            $view->save();
        } else {
            $data = [];
            array_push($data, ['date' => $date, 'qty' => 0]);
            AdView::create([
                'ads_id' => $ads_id,
                'days' => serialize($data),
            ]);
        }
        return response()->json(['data' => $data]);
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
    public function index(Request $request)
    {
        $ads_id = $request->ad_id;
        $chartDAta = [];
        $view = AdView::where('ads_id', $ads_id)->first();
        if ($view) {

            $data = unserialize($view->days);
            $date = Carbon::now()->addDays()->format('d-m-y');
            $period =  CarbonPeriod::create(Carbon::now()->addDays(-21), Carbon::now()->addDays(0));
            foreach ($period as $item) {
                array_push($chartDAta, ['date' => $item->format('Y,m,d'), 'qty' => 0]);
            }
            for ($i = 0; $i < count($chartDAta); $i++) {
                foreach ($data as $date) {
                    if ($chartDAta[$i]['date'] == $date['date']) {

                        $chartDAta[$i]['qty'] = $date['qty'];
                    }
                }
            }
        }
               

        return response()->json(['dates' => $chartDAta]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdView  $adView
     * @return \Illuminate\Http\Response
     */
    public function getIp(Request $request)
    {
        $ip = $request->ip();
        return response($ip);
    }
    public function show(AdView $adView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdView  $adView
     * @return \Illuminate\Http\Response
     */
    public function edit(AdView $adView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdView  $adView
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdView $adView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdView  $adView
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdView $adView)
    {
        //
    }
}
