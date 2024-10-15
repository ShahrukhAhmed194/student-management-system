<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\PaymentService;
use App\Traits\validators\BkashPaymentValidator;
use App\Traits\Utils;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class BkashController extends Controller
{
    private $base_url, $request;
    use PaymentService, Utils, BkashPaymentValidator;

    public function __construct()
    {
        // Sandbox
        // $this->base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        // Live
        $this->base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta';  
    }

    public function authHeaders(){
        return array(
            'Content-Type:application/json',
            'Authorization:' .$this->grant(),
            'X-APP-Key:'.env('BKASH_CHECKOUT_URL_APP_KEY')
        );
    }
         
    public function curlWithBody($url,$header,$method,$body_data_json){
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

    public function payment(Request $request)
    {
        return view('bkash.pay');
    }

    public function createPayment(Request $request)
    {
        $validator = $this->validateBkashPaymentOfParent($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $header =$this->authHeaders();

        $website_url = URL::to("/");

        $body_data = array(
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => $website_url.'/bkash/callback?student_id='.$request->bkash_student_id.'&installment='.$request->bkash_installment.'&transaction_purpose='.$request->bkash_transaction_purpose.'&transaction_type='.$request->bkash_transaction_type.'&for_month='.$request->bkash_for_month.'&notes='.$request->bkash_notes.'&agreement='.$request->bkash_agreement,
            'amount' => $request->bkash_fees ? $request->bkash_fees : 10,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => "Inv".Str::random(8) // you can pass here OrderID 
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/create',$header,'POST',$body_data_json);

        return redirect((json_decode($response)->bkashURL));
    }

    public function executePayment($paymentID, $request)
    {
        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $paymentID
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/execute',$header,'POST',$body_data_json);

        $res_array = json_decode($response,true);

        if(isset($res_array['trxID'])){
            // your database insert operation
            // save $response
            request()->request->add([
                'invoice_id' => $this->getUniqueId(6), 
                'transaction_id' => $res_array['trxID'], 
                'fees' => $res_array['amount'],
                'date' => now()->format('Y-m-d'),
                'bkash_response' => $response,
                'send_confirmation' => 1
            ]);
            $this->updateStudentAfterBkashPayment($request);
            $this->saveOrUpdateBkashPayment($request);
            $this->saveBkashResponse($request);
        }

        return $response;
    }

    public function queryPayment($paymentID)
    {

        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $paymentID,
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/status',$header,'POST',$body_data_json);
        
        $res_array = json_decode($response,true);
        
        if(isset($res_array['trxID'])){
            // your database insert operation
            // insert $response to your db
        }

         return $response;
    }

    public function callback(Request $request)
    {
        $allRequest = $request->all();
        if(isset($allRequest['status']) && $allRequest['status'] == 'failure'){
            return view('bkash.fail')->with([
                'response' => 'Payment Failure'
            ]);

        }else if(isset($allRequest['status']) && $allRequest['status'] == 'cancel'){
            return view('bkash.fail')->with([
                'response' => 'Payment Cancell'
            ]);

        }else{
            
            $response = $this->executePayment($allRequest['paymentID'], $request);

            $arr = json_decode($response,true);
            
            if(array_key_exists("statusCode",$arr) && $arr['statusCode'] != '0000'){
                return view('bkash.fail')->with([
                    'response' => $arr['statusMessage'],
                ]);
            }else if(array_key_exists("message",$arr)){
                // if execute api failed to response
                sleep(1);
                $query = $this->queryPayment($allRequest['paymentID']);
                return view('bkash.success')->with([
                    'response' => $query
                ]);
            }
            return view('bkash.success')->with([
                'response' => $response
            ]);

        }

    }

    public function getRefund(Request $request)
    {
        return view('bkash.refund');
    }

    public function refundPayment(Request $request)
    {
        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'amount' => $request->amount,
            'trxID' => $request->trxID,
            'sku' => 'sku',
            'reason' => 'Quality issue'
        );
     
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/refund',$header,'POST',$body_data_json);
        
        // your database operation
        // save $response
        return view('bkash.refund')->with([
            'response' => $response,
        ]);
    }        
    
}
