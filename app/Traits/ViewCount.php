<?php

namespace App\Traits;

use App\Models\AdView;
use Carbon\Carbon;
trait ViewCount
{
    protected function CountHandler($ads_id)
    {
      
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
                array_push($data, ['date' => $date, 'qty' => 1]);
            }
            $view->days = serialize($data);
            $view->save();
            
        } else {
            $data = [];
            array_push($data, ['date' => $date, 'qty' => 1]);
            AdView::create([
                'ads_id' => $ads_id,
                'days' => serialize($data),
            ]);
        }
        // return response()->json(['data' => $data]);
      
    }
}
