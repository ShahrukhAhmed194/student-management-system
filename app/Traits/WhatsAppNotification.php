<?php
namespace App\Traits;

trait WhatsAppNotification{
    
    function sendWANotification($receiver_number, $msg) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance28096/messages/chat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "token=oevjn3sqa4jpgaun&to=$receiver_number&body=$msg&priority=1&referenceId=",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    function sendWANotificationSecond($receiver_number, $msg) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance60418/messages/chat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "token=40b9xtzz5omb5utv&to=$receiver_number&body=$msg&priority=1&referenceId=",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function sendWAAttachment($receiver_number, $waAttachmentData){
        // dd($waAttachmentData);
        $params = array(
            'token' => '40b9xtzz5omb5utv',
            'to' => "$receiver_number",
            'filename' => $waAttachmentData['attachmentName'],
            'document' => $waAttachmentData['attachment'], //'https://file-example.s3-accelerate.amazonaws.com/documents/cv.pdf',
            'caption' => 'Sales Report'
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ultramsg.com/instance60418/messages/document",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
    }
}