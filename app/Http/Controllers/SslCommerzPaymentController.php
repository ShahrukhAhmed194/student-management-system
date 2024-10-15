<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use App\Traits\WhatsAppNotification;
use App\Traits\PaymentService;
use App\Traits\validators\PaymentValidator;
use App\Traits\NotifyParent;
use App\Traits\SendMessage;
use App\Traits\Utils;

class SslCommerzPaymentController extends Controller
{
    use NotifyParent, SendMessage, PaymentService, Utils, WhatsAppNotification, PaymentValidator;

    public function exampleEasyCheckout()
    {
        return view('parents.payments.exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('parents.payments.exampleHosted');
    }

    public function index(Request $request){
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $validator = $this->validateParentsSSLpayment($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        
        $post_data = array();
        $post_data['total_amount'] = $request->fees; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $invoice_id = $this->getUniqueId(6);
        $date = date('Y-m-d');

        $request->request->add(['invoice_id' => $invoice_id]);
        $request->request->add(['transaction_id' => $post_data['tran_id']]);
        $request->request->add(['date' => $date]);
        $request->request->add(['transaction_type' => 'Bank/Card']);
        $request->request->add(['payment_status' => 'Completed']);
        $request->request->add(['send_confirmation' => 1]);

        $post_data['student_id'] = $request->student_id;
        $post_data['installment'] = $request->installment;
        $post_data['transaction_purpose'] = $request->transaction_purpose;
        $post_data['notes'] = $request->notes;
        $post_data['invoice_id'] = $invoice_id;
        
        $studentInfo = Student::find($request->student_id);
        $parent_id = $studentInfo->parent_id;
        $parentInfo = DB::table('parents')->where("user_id", "=", $parent_id)->first();

        $country = $parentInfo->country;

        if($country != 'Bangladesh'){
            return view('stripe/stripe', compact('post_data'));
            exit();
        }

        $this->saveOrUpdatePayment($request);
        $this->updateStudentAfterPayment($request);
        $sms_msg ="[Dreamers] আপনার সন্তানের ফী জমা হয়েছে। তারিখঃ $date, ফীঃ ৳$request->fees";

        if(config('app.env') === 'production'){
            $this->SMSNotification($parentInfo->phone, $sms_msg);
        }
        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');


        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function online_payment(Request $request){
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $request->fees; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        // # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "withoutlogin";
        

        $invoice_id = $this->getUniqueId(6);

        $request->request->add(['invoice_id' => $invoice_id]);
        $request->request->add(['transaction_id' => $post_data['tran_id']]);
        
        $post_data['student_id'] = $request->student_id;
        $post_data['installment'] = $request->installment;
        $post_data['transaction_purpose'] = $request->transaction_purpose;
        // $post_data['notes'] = $request->notes;
        $post_data['invoice_id'] = $invoice_id;
        
        $studentInfo = Student::find($request->student_id);
        $parent_id = $studentInfo->parent_id;
        $parentInfo = DB::table('parents')->where("user_id", "=", $parent_id)->first();

        $country = $parentInfo->country;
       
        if($country != 'Bangladesh'){
            return view('stripe/stripe', compact('post_data'));
            exit();
        }

        $this->saveOrUpdatePayment($request);
        $this->updateStudentAfterPayment($request);
        $date = date('Y-m-d');
        $sms_msg ="[Dreamers] আপনার সন্তানের ফী জমা হয়েছে। তারিখঃ $date, ফীঃ ৳$request->fees";

        if(config('app.env') === 'production'){
            $this->SMSNotification($parentInfo->phone, $sms_msg);
        }

             $whatapp_msg = $sms_msg;
            /**
             *  Send sms to parent for payment confirmation
             *  paremeter : phoneNumber , messageFormate.
             */
            if(config('app.env') === 'production'){
                $this->sendWANotification($parentInfo->phone, $whatapp_msg);
            }

            $parent = User::where('id', $parent_id)->first();
            /*
            Send email to parent for payment confirmation
            parameter: sender mail, parent name, payment id
            */
        
        $paymentInfo = DB::table('payments')->where("invoice_id", "=", $invoice_id)->first();

         $payConfirmationContent = [
                'parents_email' => $parent->email,
                'parent_name' => $parent->name,
                'pay_id' => $paymentInfo->id,
            ];
        Mail::to($parent->email)
            ->send(new \App\Mail\NotifyPayConfirmationMailer($payConfirmationContent));
        
        $post_data['pay_id'] = $paymentInfo->id;

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here)
        
        $payment_options = $sslc->makePayment($post_data, 'hosted');
    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $update_product = DB::table('payments')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'student_id' => 1,
                'fees' => 1000,
                'date' => Date(now()),
                'transaction_type' => 'monthly',
                'transaction_id' => $post_data['tran_id'],
                'notes' => 'notes',
                'payment_status' => 'Pending',
                'invoice_sent' => false
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        $value_b = $request->input('value_b');
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $payment = Payment::where('transaction_id', $tran_id)->first();


        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('payments')
            ->where('transaction_id', $tran_id)
            ->select('id', 'transaction_id', 'payment_status')->first();


        if ($order_detials->payment_status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('payments')
                    ->where('transaction_id', $tran_id)
                    ->update([
                        'payment_status' => 'Complete',
                        'currency' => $currency
                        ]);
            
                //parameter: sender mail, parent name, payment id
                $payConfirmationContent = [
                    'parents_email' => $payment->student->parent->email,
                    'parent_name' => $payment->student->parent->name,
                    'pay_id' => $payment->id,
                ];
        Mail::to($payment->student->parent->email)
            ->send(new \App\Mail\NotifyPayConfirmationMailer($payConfirmationContent));

                toastr()->success('Transaction is successfully Completed');
                return redirect('/payment');
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                echo "validation Fail";
            }
        } else if ($order_detials->payment_status == 'Processing' || $order_detials->payment_status == 'Completed') {
                    
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
             if($value_b == 'withoutlogin'){

                $successdata['tran_id'] = $tran_id;
                $successdata['pay_id'] = $order_detials->id;
                return view('parents/payments/onlineSuccess', compact('successdata'));
             }else{
                toastr()->success('Payment Added Successfully.');
                return redirect()->back();
             }
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Completed') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Completed') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
