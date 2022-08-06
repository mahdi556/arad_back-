<?php

namespace App\Traits;

use App\Models\IpUser;
use App\Traits\ViewCount;

trait CheckIp
{
    use ViewCount;
    protected function getIp($user_ip, $ad_id)
    {
        $ip = IpUser::where('ip', $user_ip)->first();
        if ($ip) {
            
            $ads = unserialize($ip->ads);
            if (!in_array($ad_id, $ads)) {
                array_push($ads, $ad_id);
                $this->CountHandler($ad_id);
            }
        } else {
            $ads = [];
            array_push($ads, $ad_id);
            IpUser::create([
                'ip' => $user_ip,
                'ads' => serialize($ads)
            ]);
            $this->CountHandler($ad_id);
        }
    }
}
