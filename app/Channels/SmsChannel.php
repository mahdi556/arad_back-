<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $client = new \SoapClient("http://ippanel.com/class/sms/wsdlservice/server.php?wsdl", array('encoding' => 'UTF-8'));

        $pass = "Saham@8455";
        $fromNum = "3000505";
        $pattern_code = "cc778sse6k";
        $user = "9133048270";
        $toNum = $notification->cellphone;
        $input_array = array("verification-code" => $notification->code);

            /*echo "$this->phone : $this->text" . "\n"*/;
        /*echo*/
        $client->sendPatternSms($fromNum, $toNum, $user, $pass, $pattern_code, $input_array);/*. "\n"*/;
    }
}
