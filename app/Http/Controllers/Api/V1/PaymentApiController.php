<?php

namespace App\Http\Controllers\API\V1;

use Auth;
use Validator;
use App\Models\User;
use App\Traits\Utils;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Services\ApiServices\PaymentApiServices;
use App\Services\ApiServices\UtilsApiServices;
use App\DAO\ApiDao\PaymentApiDao;
use App\DAO\ApiDao\StudentApiDao;
use App\Traits\Api\Validators\ApiValidator;


class PaymentApiController extends Controller
{
    use Utils, ApiValidator;
    protected $payment_api_services, $utils_api_services, $payment_api_dao;
    protected $student_api_dao;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api');
        $this->payment_api_services = new PaymentApiServices();
        $this->utils_api_services = new UtilsApiServices();
        $this->payment_api_dao = new PaymentApiDao();
        $this->student_api_dao = new StudentApiDao();
    }

    public function payments($user_id){
        $student = $this->student_api_dao->getStudentByUserId($user_id);
        if($student){
            $payload = $this->payment_api_services->getStudentPaymentHistory($user_id);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }

    public function makePayment($student_id){
        $studentInfo = $this->student_api_dao->getStudentById($student_id);
        
        if($studentInfo){
            $payload = $this->payment_api_services->getStudentPayableData($studentInfo);
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }

    
    public function payment(Request $request){
        $validator = $this->paymentDataValidate($request);
        
        if ($validator->fails()) {
            $response = array(
                'status' => false,
                'message' => $validator->errors(),
            );
            return response()->json($response, 422);
        }

        $invoice_id = $this->getUniqueId(6);
        $request->merge(['invoice_id' => $invoice_id]);
        
        
        $payment = $this->payment_api_dao->saveOrUpdatePayment($request);
        $student = $this->payment_api_dao->updateStudentAfterPayment($request);
        
        if($payment){
            $payload = array(
                'student_id' => $payment[0]->student_id,
                'amount' => $payment[0]->fees,
                'installment' => $payment[0]->installment,
                'purpose' => $payment[0]->transaction_purpose,
                'for_month' => json_decode($payment[0]->for_month),
                'notes' => $payment[0]->notes,
                'agreement' => $payment[0]->agreement,
            );
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        
        return response()->json($response);
    }

    public function getChildrenPaymentHistoryOfAParent($parent_user_id)
    {
        $payload = $this->payment_api_dao->getChildrenPaymentHistory($parent_user_id);

        if($payload){
            $response = $this->utils_api_services->getOkResponse($payload);
        }else{
            $response = $this->utils_api_services->getNotFoundResponse();
        }
        return $response;
    }
}
