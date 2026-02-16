<?php

namespace App\Http\Traits;

trait Sms
{
    public function smsSend($sender, $content)
    {
        $url = 'https://bulksmsbd.net/api/smsapi';
        $api_key = env('BULKSMS_API_KEY');
        $senderid = 'helpNhelper';
        $number = $sender;
        $message = $content;

        $data = [
            'api_key' => $api_key,
            'senderid' => $senderid,
            'number' => $number,
            'message' => $message,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
