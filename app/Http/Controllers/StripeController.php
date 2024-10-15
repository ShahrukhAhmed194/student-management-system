<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\Student;
use Session;
use Stripe;

class StripeController extends Controller{
   
    public function index(){
        
    }

    public function stripe(){
        $post_data['total_amount'] = '';
        return view('stripe/stripe', compact('post_data'));
    }

    public function stripePost(Request $request){
         $token = $request->stripeToken;

         $validated = $request->validate([
            'cardName' => 'required',
            'cardNumber' => 'required',
            'card_cvc' => 'required',
            'card_exp_month' => 'required',
            'card_exp_year' => 'required',
        ]);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripedata = Stripe\Charge::create ([
                "amount" => $request->total_amount, //100*100,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => date('Y-m-d'). " This is another payment",
        ]);

        if($stripedata->status == 'succeeded'){
            $update_product = DB::table('payments')
                ->where('transaction_id', $request->tran_id)
                ->updateOrInsert([
                    'student_id' => $request->student_id,
                    'fees' => $request->total_amount,
                    'currency' => 'USD',
                    'date' => Date(now()),
                    'transaction_type' => 'stripe',
                    'transaction_id' => $request->tran_id,
                    'installment' => $request->installment,
                    'notes' => $request->notes,
                    'payment_status' => (($stripedata->status == 'succeeded') ? 'Complete' : $stripedata->status),
                    'transaction_purpose' => $request->transaction_purpose,
                    'invoice_id' => $request->invoice_id,
                    'invoice_sent' => false
                ]);

                $payment = Payment::where('transaction_id', $request->tran_id)->first();
        }
        
        toastr()->success('Payments info stored successfully.');
        return redirect('/payment');
    }
}
