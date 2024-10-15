<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait NotifyParent{
    public function paymentConfirmationMail($to, $parent, $pay_id){
        $body ="<h2>Assalamu Alaikum,<br>
        Greetings from Dreamers Academy.<br><br></h2>
        <p>Mr./Mrs. $parent Your payment for your child has been completed..<br><br></p>
        <a href='https://dreamers.lead.academy/payment/$pay_id/invoice' style='margin-left:40%; '>
        <button  style='background-color:black; color:white; padding:8px'>Invoice</button></a><br><br>
        <p>For further queries, please contact us at: +880 1897-717780; +880 1897-717781.<br></p>
        <h2>Thanks,<br>
        Dreamers Academy.</h2>";

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer EHnqWVITSf5xpQ9ctQzx1jCBYWVd2NuU4UVJCvU2',
        ])->post('https://app.dreamersacademy.xyz/api/mail/send', [
            'from' => 'dreamersacademy.xyz@gmail.com',
            'to' =>  $to,
            'subject' => 'Payment Confirmation',
            'body' => $body
        ]);
    }
}
