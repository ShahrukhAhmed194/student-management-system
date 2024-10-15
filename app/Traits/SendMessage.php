<?php
namespace App\Traits;

trait SendMessage{
    function SMSNotification($receiver_number, $msg) {
        
        $url = "https://msg.elitbuzz-bd.com/smsapi";
        $data = [
          "api_key" => "C2008231624d82728b5359.67032671",
          "type" => "text",
          "contacts" => "$receiver_number",
          "senderid" => "8809612472933",
          "msg" => "$msg",
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