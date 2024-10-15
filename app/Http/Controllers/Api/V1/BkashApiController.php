<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\validators\BkashPaymentValidator;
use App\Traits\{PaymentService, Utils};
use App\Services\ApiServices\UtilsApiServices;

class BkashApiController extends Controller
{
    private $base_url, $utils_api_services;
    use PaymentService, Utils, BkashPaymentValidator;

    public function __construct()
    {
        $this->base_url = env('BKASH_BASE_URL');
        $this->utils_api_services = new UtilsApiServices();

    }

    public function authHeaders()
    {
        return array(
            'Content-Type:application/json',
            'Authorization:' .$this->grant(),
            'X-APP-Key:'.env('BKASH_CHECKOUT_URL_APP_KEY')
        );
    }
         
    public function curlWithBody($url,$header,$method,$body_data_json)
    {
        $curl = curl_init($this->base_url.$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $body_data_json);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function grant()
    {
        $header = array(
                'Content-Type:application/json',
                'username:'.env('BKASH_CHECKOUT_URL_USER_NAME'),
                'password:'.env('BKASH_CHECKOUT_URL_PASSWORD')
                );
        $header_data_json=json_encode($header);

        $body_data = array('app_key'=> env('BKASH_CHECKOUT_URL_APP_KEY'), 'app_secret'=>env('BKASH_CHECKOUT_URL_APP_SECRET'));
        $body_data_json=json_encode($body_data);
    
        $response = $this->curlWithBody('/tokenized/checkout/token/grant',$header,'POST',$body_data_json);

        $token = json_decode($response)->id_token;

        return $token;
    }

    public function success(Request $request)
    {
        $validator = $this->validateBkashPaymentOfAndroidApp($request);
        if ($validator->fails()) {
            return $this->utils_api_services->getValidationMessages($validator);
        }
        $body_data = array(
            'trxID' => $request->transaction_id
        );
        $header =$this->authHeaders();
        $body_data_json=json_encode($body_data);
        $response = $this->curlWithBody('/tokenized/checkout/general/searchTransaction',$header,'POST',$body_data_json);
        $bkash_response = json_decode($response,true);

        if($bkash_response['statusCode'] == '0000' && $bkash_response['trxID'] == $request->transaction_id){
            $student = $this->updateStudentAfterBkashPayment($request);
            $this->saveOrUpdateBkashPayment($request);
            request()->request->add([
                'bkash_response' => $bkash_response,
            ]);
            $this->saveBkashResponse($request);
            $payload = array(
                'student_id' => $student->id,
                'student_name' => $student->user->name,
                'payment_status' => 1,
                'amount' => $request->fees,
                'status_code' => '0000'
            );

            return $this->utils_api_services->getOkResponse($payload);
        }else{

            return $this->utils_api_services->getNotFoundResponse();
        }

        
    }
}
