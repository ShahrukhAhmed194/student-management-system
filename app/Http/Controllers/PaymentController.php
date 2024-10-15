<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Student;
use App\Models\StudentsParent;
use App\Traits\Utils;
use App\Traits\NotifyParent;
use App\Traits\StudentService;
use App\Traits\PaymentService;
use App\Traits\SendMessage;
use App\Traits\WhatsAppNotification;
use App\Traits\validators\PaymentValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use App\Services\WebServices\{BkashServices, PaymentServices};


class PaymentController extends Controller
{
    use Utils, NotifyParent, StudentService, PaymentService, SendMessage, WhatsAppNotification, PaymentValidator;

    protected $bkash_services;
    public $user, $payment_services;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });

        $this->payment_services = new PaymentServices();
        $this->bkash_services = new BkashServices();

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth('web')->user()->can('payment.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view payment list !');
        }
        $get_studentinfo = Student::where('parent_id', auth()->user()->id)->get();
        $studentids = array();
        foreach ($get_studentinfo as $value) {
            $studentids[]=$value->id;
        }
        $payments = Payment::whereIn('student_id', $studentids)->orderBy('date', 'desc')->get();
        
        return view('parents.payments.index', [
            'payments' => $payments //Payment::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $months = $this->getMonthsList();
        return view('parents.payments.create', [
            'students' => Student::where('parent_id', auth()->user()->id)->get(),
            'months' => $months
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment = Payment::create([
            'student_id' => $request->student_id,
            'fees' => $request->amount,
            'date' => Date(now()),
            'transaction_type' => $request->transaction_type,
            'transaction_id' => '1234',
            'notes' => $request->notes,
            'payment_status' => 'Pending',
            'invoice_sent' => false
        ]);

        toastr()->success('Payments info stored successfully.');
        return redirect()->route('payment.index');
    }

    public function invoice($id)
    {
        if (!auth('web')->user()->can('payment.list')) {
            abort(403, 'Sorry !! You are Unauthorized to view payment invoice !');
        }
        
        $payment = Payment::find($id);
        
        if (!$payment) {
            abort(404, 'Sorry !! Payment not found!');
        }
        
        $pdf = PDF::loadview('parents.payments.invoice', ['payment' => $payment]);

        return $pdf->stream('invoice.pdf');
    }

    public function success()
    {
        return view('parents.payments.success');
    }

    public function getAllPaymentHistory(){
        if (is_null($this->user) || !$this->user->can('payment.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any payment!');
        }
        $data['id'] = $data['from_date'] = $data['to_date'] = $data['transaction_type'] = $data['currency'] = '' ;
        $runningMonth = date('m');

        $students = Student::select('students.id', 'students.student_id', 'students.user_id', 'students.status', 'users.name')
                        ->join('users', 'users.id', 'students.user_id')
                        ->orderBy('users.name', 'ASC')
                        ->get();
        $lastMonthAllPayments = Payment::with('student.user')
                                ->whereMonth('date', $runningMonth)
                                ->where('status', 1)
                                ->orderBy('date', 'desc')
                                ->get();

        return view('payment.payment-history',compact('students', 'lastMonthAllPayments', 'data'));
    }

    public function filter_payment_history(Request $request){
        $id = $request->student_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $transaction_type = $request->transaction_type;
        $currency = $request->currency;

        $data['id'] = $id;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['transaction_type'] = $transaction_type;
        $data['currency'] = $currency;
        $students = Student::select('students.id', 'students.student_id', 'students.user_id', 'students.status', 'users.name')
                    ->join('users', 'users.id', 'students.user_id')
                    ->orderBy('users.name', 'ASC')
                    ->get();
        
        $lastMonthAllPayments = [];

        if($id && $from_date && $to_date && $transaction_type && $currency){
            $lastMonthAllPayments = Payment::with('student.user')
                    ->where('student_id', $id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->where('transaction_type', $transaction_type)
                    ->where('currency', $currency)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($id && $from_date && $to_date && $transaction_type){
             $lastMonthAllPayments = Payment::with('student.user')
                    ->where('student_id', $id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->where('transaction_type', $transaction_type)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($id && $from_date && $to_date){
            $lastMonthAllPayments = Payment::with('student.user')
                    ->where('student_id', $id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($from_date && $to_date && $transaction_type){
            $lastMonthAllPayments = Payment::with('student.user')
                    ->whereBetween('date', [$from_date, $to_date])
                    ->where('transaction_type', $transaction_type)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($from_date && $to_date && $currency){
            $lastMonthAllPayments = Payment::with('student.user')
                    ->whereBetween('date', [$from_date, $to_date])
                    ->where('currency', $currency)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($from_date && $to_date){
            $lastMonthAllPayments = Payment::with('student.user')
                    ->whereBetween('date', [$from_date, $to_date])
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($id){
            $lastMonthAllPayments = Payment::with('student.user')
                    ->where('student_id', $id)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($transaction_type){
            $lastMonthAllPayments = Payment::with('student.user')
                    ->where('transaction_type', $transaction_type)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($currency){
            $lastMonthAllPayments = Payment::with('student.user')
                    ->where('currency', $currency)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }



        return view('payment.payment-history',compact('students', 'lastMonthAllPayments', 'data'));
    }

    public function load_allchild(Request $request)
    {
        $students = DB::select("SELECT users.id userID, users.name, students.id studentID, students.status, students.student_id
                 FROM students 
                 JOIN users ON users.id = students.user_id
                 ORDER BY users.name ASC");

        echo "<option value=''>Select Child</option>";
        foreach ($students as $student) {
            $status = $student->status == 1 ? '' : '( Inactive )';
            $selected = $student->studentID == $request->student_id ? 'selected' : '';
            echo "<option value='{$student->studentID}' $selected>{$student->name} ({$student->student_id}) $status</option>";
        }
    }

    public function addNewPayment(){
        if (is_null($this->user) || !$this->user->can('payment.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any payment !');
        }
        
        $today =  Carbon::now();
        $months = $this->getMonthsList();
        
        return view('payment.add-payment',compact('today', 'months'));
    }

    public function getPaymentDetails(Request $request){
        $id = $request->id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $transaction_type = $request->transaction_type;
        $currency = $request->currency;

        if($id && $from_date && $to_date && $transaction_type && $currency){
            $payments = Payment::with('student.user')
                    ->where('student_id', $id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->where('transaction_type', $transaction_type)
                    ->where('currency', $currency)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($id && $from_date && $to_date && $transaction_type){
             $payments = Payment::with('student.user')
                    ->where('student_id', $id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->where('transaction_type', $transaction_type)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($id && $from_date && $to_date){
            $payments = Payment::with('student.user')
                    ->where('student_id', $id)
                    ->whereBetween('date', [$from_date, $to_date])
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($from_date && $to_date){
            $payments = Payment::with('student.user')
                    ->whereBetween('date', [$from_date, $to_date])
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($id){
            $payments = Payment::with('student.user')
                    ->where('student_id', $id)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($transaction_type){
            $payments = Payment::with('student.user')
                    ->where('transaction_type', $transaction_type)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }elseif($currency){
            $payments = Payment::with('student.user')
                    ->where('currency', $currency)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
        }

        return $payments;
    }

    public function addPaymentByAdmin(Request $request){
        
        $validator = $this->validatePaymentByAdmin($request);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $student_id = $request->student_id;
        $studentInfo = Student::where('id', $student_id)->first();
        $send_confirmation = $request->send_confirmation;
        $invalid = $request->invalid;
        $sms_msg ="[Dreamers] আপনার সন্তানের (".$studentInfo->user->name.")".($request->transaction_purpose == 'robotics-kit' ? ' রোবোটিক্স কিট' : '')." ফী জমা হয়েছে। তারিখঃ ".$request->date.", মাসঃ". implode(',' , $request->for_month)."; ফীঃ ৳".$request->fees."|";
        $invoice_id = $this->getUniqueId(6);
        $request->merge(['invoice_id' => $invoice_id]);

        $payment = $this->saveOrUpdatePayment($request);
        $student = $this->updateStudentAfterPayment($request);
        if($request->transaction_type == 'bkash'){
            $this->bkash_services->updateBkashTransactionPaymentID($payment[0]->id, $request->transaction_id);
        }

        if($send_confirmation == 1){
            $parent = User::where('id', $student->parent_id)->first();
            /*
            Send email to parent for payment confirmation
            parameter: sender mail, parent name, payment id
            */
        
            $payConfirmationContent = [
                'parents_email' => $parent->email,
                'parent_name' => $parent->name,
                'pay_id' => $payment[0]->id,
                'transaction_purpose' => $request->transaction_purpose,
            ];
          /*  Mail::to($parent->email)
                ->cc('tanisha.dreamers@gmail.com')
                ->bcc('khadiza.dreamers@gmail.com')
                ->send(new \App\Mail\NotifyPayConfirmationMailer($payConfirmationContent));
	   */
	}

        $parent =  DB::table('parents')->where('user_id', $student->parent_id)->first();

        if($send_confirmation == 1){
            /**
             *  Send sms to parent for payment confirmation
             *  paremeter : phoneNumber , messageFormate.
             */
           /* if(config('app.env') === 'production'){
                $this->SMSNotification($parent->phone, $sms_msg);
	}*/
    	}
        $whatapp_msg = $sms_msg;
        if($send_confirmation == 1){
            /**
             *  Send sms to parent for payment confirmation
             *  paremeter : phoneNumber , messageFormate.
             */
            if(config('app.env') === 'production'){
                $this->sendWANotificationSecond($parent->phone, $whatapp_msg);
	}
        }
        
        toastr()->success('Payment Added Successfully.');

        return redirect('payment-add-new');
    }

    public function getAutoFillData($id){

        return $this->findStudentById($id);
    }

     public function payment_edit($id){
        if (is_null($this->user) || !$this->user->can('payment.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any payment!');
        }

        $getPayment = Payment::with('student.user:id,name')->where('id', $id)->first();
        
        if (!$getPayment) {
            abort(404, 'Sorry !! Payment not found!');
        }
        
        $today =  Carbon::now();
        $months = $this->getMonthsList();
        
        $students = DB::select("SELECT users.id userID, users.name, students.id studentID, students.status, students.student_id
                     FROM students
                     LEFT JOIN users ON users.id = students.user_id
                     ORDER BY users.name ASC");
        
        
        return view('payment.payment_edit',compact('today', 'months', 'getPayment', 'students'));
    }


    public function updatePaymentByAdmin(Request $request){
        $validator = $this->validatePaymentUpdateByAdmin($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $student_id = $request->student_id;
        $studentInfo = Student::where('id', $student_id)->first();        
        $sms_msg ="[Dreamers] আপনার সন্তানের (".$studentInfo->user->name.")".($request->transaction_purpose == 'robotics-kit' ? ' রোবোটিক্স কিট' : '')."  ফী জমা হয়েছে। তারিখঃ $request->date, মাসঃ". implode(',' , $request->for_month)."; ফীঃ ৳$request->fees";

        $invoice_id = $this->getUniqueId(6);
        $request->merge(['invoice_id' => $invoice_id]);

        $payment = $this->saveOrUpdatePayment($request);
        $student = $this->updateStudentAfterPayment($request);

        if($request->email_notification || $request->send_confirmation){
            $parent = User::where('id', $student->parent_id)->first();
            /*
            Send email to parent for payment confirmation
            parameter: sender mail, parent name, payment id
            */
        
            $payConfirmationContent = [
                'parents_email' => $parent->email,
                'parent_name' => $parent->name,
                'pay_id' => $payment[0]->id,
                'transaction_purpose' => $request->transaction_purpose,
            ];
            Mail::to($parent->email)
                ->send(new \App\Mail\NotifyPayConfirmationMailer($payConfirmationContent));
        }

        $parent =  DB::table('parents')->where('user_id', $student->parent_id)->first();
        if($request->sms_notification || $request->send_confirmation){
            /**
             *  Send sms to parent for payment confirmation
             *  paremeter : phoneNumber , messageFormate.
             */
            if(config('app.env') === 'production'){
                $this->SMSNotification($parent->phone, $sms_msg);
            }
        }
        $whatapp_msg = $sms_msg;
        if($request->whatsapp_notification || $request->send_confirmation){
            /**
             *  Send sms to parent for payment confirmation
             *  paremeter : phoneNumber , messageFormate.
             */
            if(config('app.env') === 'production'){
                $this->sendWANotificationSecond($parent->phone, $whatapp_msg);
            }
        }
        
        toastr()->success('Payment Updated Successfully.');

        return redirect()->back();
    }

     public function paymentFormWithoutLogin(){
        return view('parents.payments.paymentFormWithoutLogin', [
        ]); 
    }

    public function get_parentinfo_byphone(Request $request){
        $phone = $request->phone;
        $parentInfo = StudentsParent::where('phone', $phone)->first();
        if($parentInfo){
            $parentUserId = $parentInfo->user_id;
        $studentInfo = Student::
                        with('user')
                        ->where('parent_id', $parentUserId)
                        ->get();

        
        $html='';
        if($studentInfo){
         $html.='
            <span style="color:#e41111">*</span>
            <label for="student_id" class="form-label">Child</label>
            <select id="student_id" name="student_id" class="form-select choices" onchange="autoFillData()" required>
                <option value="">Select Child</option>';
                foreach($studentInfo as $student){
                $html.='<option value="'.$student->id.'">'.$student->user->name.'</option>';
                }
        $html.='</select>
            <small class="text-danger" style="font-size: 10px;">Child is required</small>
            <br>
            <span style="color:#e41111">*</span>
            <label for="fees" class="form-label">Amount</label>
            <input type="number" id="fees" name="fees" class="form-control" required>
            <small class="text-danger" style="font-size: 10px;">Amount is required</small>
            <br>

            <span style="color:#e41111">*</span>
            <label for="for_month" class="form-label">Month</label>
            <select id="for_month" name="for_month[]" class="form-select for_month" required multiple data-placeholder="select month">
            <option value="">select month</option>
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
            </select>
            <small class="text-danger" style="font-size: 10px;">Month is required</small>
        ';
        echo $html;
        }
        }else{
            echo "notfound";
        }

    }

    public function getStudentsPaymentHistory($id)
    {
        $lastMonthAllPayments = $this->payment_services->getPaymentHistoryOfStudent($id);
        
        return view('students.tabs.payment-history', compact('lastMonthAllPayments'));
    }
    
    public function delete($id)
    {
        if (!can('payment_delete')) {
            abort(403, unauthorized());
        }
        $payment = Payment::findOrFail(decrypt($id));
        $payment->is_delete = true;
        $payment->save();
        
        $url = route('payment.history');
        return response()->json(['status' => 'success', 'message' => 'Payment Deleted Successfully', 'url' => $url], 200);
    }
}
