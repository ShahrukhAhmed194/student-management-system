<?php
namespace App\Traits;

use GuzzleHttp\Client;
use Log;

/**
 * trait ZoomMeetingTrait
 */
trait ZoomMeeting
{
    public $client;
    public $jwt;
    public $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }
    public function generateZoomToken()
    {
        // $key = env('ZOOM_API_KEY', '');
        // $secret = env('ZOOM_API_SECRET', '');
        // $payload = [
        //     'iss' => $key,
        //     'exp' => strtotime('+1 minute'),
        // ];
        
        // return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
        return "eyJzdiI6IjAwMDAwMSIsImFsZyI6IkhTNTEyIiwidiI6IjIuMCIsImtpZCI6ImQyNDZiMTZiLTQ3ZDItNDMxNC1hZGRlLWU5ZTA5MTJlZDhjMSJ9.eyJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJNaExkMzdyeVNtMmFzamZVeHRMeTJ3IiwidmVyIjo5LCJhdWlkIjoiZjA0N2U4MWY5Y2JlY2VkNDA2Y2M3MTJhMTg3MTUwYmUiLCJuYmYiOjE3MTczMzAwMDMsImNvZGUiOiJJMTBXRFZtY1JnbWRFYUFRdlpocFBBR0hFWHpqWUl6ajMiLCJpc3MiOiJ6bTpjaWQ6MXBpaXR4WkZUc0tWQWRWUnU4SUFudyIsImdubyI6MCwiZXhwIjoxNzE3MzMzNjAzLCJ0eXBlIjozLCJpYXQiOjE3MTczMzAwMDMsImFpZCI6ImJzQ09aQ1VGU0MtYnoxclhlZjJwX0EifQ.yn5mb--dhVkGX4sIhfei98_SXP1mCRWu5TBM4nqsab21e1RXEPwBjJpS5GaTPIs1E2w2AdcDphcP6x3LKrZfhg";
    }

    private function retrieveZoomUrl()
    {
        // return env('ZOOM_API_URL', '');
        return 'https://api.zoom.us/v2/';
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : '.$e->getMessage());

            return '';
        }
    }

    
    public function zoomServerToServerAccessTokenGenerate(){
        // $zoomAccountId = 'bsCOZCUFSC-bz1rXef2p_A';
        $zoomAccountId = 'bsCOZCUFSC-bz1rXef2p_A'; //new 

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=$zoomAccountId",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_HTTPHEADER => array(
            'Authorization: Basic MXBpaXR4WkZUc0tWQWRWUnU4SUFudzpHQnA0NHVQTkdOZXNINTJFOG10a3RiSjBLTnFxSUpmUw==',
            'Cookie: TS018dd1ba=01cfbc656fb82bfded7f1892bfb0adadbd1e16ce76a036dc4403356359018c22867f4cb1b79f9fb204f9edb682b40f03e7f0001c7b; TS01f92dc5=01cfbc656fb82bfded7f1892bfb0adadbd1e16ce76a036dc4403356359018c22867f4cb1b79f9fb204f9edb682b40f03e7f0001c7b; __cf_bm=Yq2lJrLzX0O2RtqKFnu2FTSiph77LKKcL3znAEqhJcA-1670051770-0-AS4hEoylEk6GjbfAsvD4Rx+HnBCG7Cw7BALHOtlDkJSp/UajhZfoyHd8VN0rbqILC8p5gzcBSiixoGRNWy23Fvg=; _zm_chtaid=97; _zm_ctaid=1gwq7OjkTPyWgmZqC1Ve_Q.1670051770335.f340ae652b072f295d6ee40300253f31; _zm_mtk_guid=212f317839d44a33bdddae3ae19ec43e; _zm_page_auth=us06_c_Xvm6l5n3S0Kgrb3l9vDnGw; _zm_ssid=us06_c_CjY6mcg_Ske477mcBGdZbw; _zm_visitor_guid=212f317839d44a33bdddae3ae19ec43e; cred=371E1296C8E2C411F3705A041E413301'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $accessToken = json_decode($response)->access_token;
        return $accessToken;
    }

    public function create($data)
    {
        $clients = new Client();
        $teacherEmail = $data['teacherEmail'];
        $path = "users/$teacherEmail/meetings";
        // $path = 'users/leadacademyinstructor@gmail.com/meetings';
        // $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();
        
        $headers = [
            'Authorization' => 'Bearer '.$this->zoomServerToServerAccessTokenGenerate(), //$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
        
        $body = [
            'headers' => $headers, //$this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => 2, //self::MEETING_TYPE_SCHEDULE, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Dhaka',
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                    // 'approval_type'      => 1,
                ],
            ]),
        ];
        // $response =  $this->client->post($url.$path, $body);
        $response =  $clients->post($url.$path, $body);
        
        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function update($id, $data)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'duration'   => $data['duration'],
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Kolkata',
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
        ];
        $response =  $this->client->patch($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function get($id)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $this->jwt = $this->generateZoomToken();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->get($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    /**
     * @param string $id
     * 
     * @return bool[]
     */
    public function delete($id)
    {
        $path = 'meetings/'.$id;
        $url = $this->retrieveZoomUrl();
        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([]),
        ];

        $response =  $this->client->delete($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 204,
        ];
    }
}
?>