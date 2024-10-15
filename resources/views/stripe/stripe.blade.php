<x-parent-layout>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <div class="pagetitle">
        <h1 class="text-center">Make Payment</h1>
    </div><!-- End Page Title -->
    <style type="text/css">
        .panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>


     <section class="section">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <form 
                                    role="form" 
                                    action="{{ route('stripe.post') }}" 
                                    method="post" 
                                    class="require-validation"
                                    data-cc-on-file="false"
                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                    id="payment-form">
                                @csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class='form-row row mt-3'>
                                            <div class='col-md-12 mt-3'>
                                                <label for="cardName" class="form-label"><span style="color:#e41111">* </span> Card Name</label>
                                                <input name="cardName" id="cardName"
                                                    class='form-control' size='4' type='text' value="" required>
                                                    <small class="text-danger" style="font-size: 10px;">Card Name is required</small>
                                            </div>
                                        </div>
                               
                                        <div class='form-row row'>
                                            <div class='col-md-12 mt-3  '>
                                                <label for="cardNumber" class='form-label'><span style="color:#e41111">* </span> Card Number</label> 
                                                <input name='cardNumber'
                                                    autocomplete='off' class='form-control card-number' size='20'
                                                    type='text' value='' required>
                                                    <small class="text-danger" style="font-size: 10px;">Card Number is required</small>
                                            </div>
                                        </div>
          
                                <div class='form-row row mt-3'>
                                    <div class='col-xs-12 col-md-4 form-group cvc'>
                                        <label class='control-label'><span style="color:#e41111">* </span> CVC</label> <input autocomplete='off'
                                            class='form-control card-cvc' placeholder='ex. 311' size='4'
                                            type='text' name="card_cvc" value="" required>
                                            <small class="text-danger" style="font-size: 10px;">CVC is required</small>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration'>
                                        <label class='control-label'><span style="color:#e41111">* </span> Expiration Month</label> <input
                                            class='form-control card-expiry-month' placeholder='MM' size='2' name='card_exp_month'
                                            type='text' value="" required>
                                            <small class="text-danger" style="font-size: 10px;">Expiration month is required</small>
                                    </div>
                                    <div class='col-xs-12 col-md-4 form-group expiration'>
                                        <label class='control-label'><span style="color:#e41111">* </span> Expiration Year</label> <input
                                            class='form-control card-expiry-year' placeholder='YYYY' size='4' name='card_exp_year'
                                            type='text' value="" required>
                                            <small class="text-danger" style="font-size: 10px;">Expiration year is required</small>
                                    </div>
                                </div>
          
                                <div class='form-row row'>
                                    <div class='col-md-12 error form-group hide'>
                                        <div class='alert-danger alert'>Please correct the errors and try
                                            again.</div>
                                    </div>
                                </div>
                                
                                <input type="hidden" class="total_amount" name="total_amount" value="{{ $post_data['total_amount'] }}">
                                <input type="hidden" class="tran_id" name="tran_id" value="{{ $post_data['tran_id'] }}">
                                <input type="hidden" class="installment" name="installment" value="{{ $post_data['installment'] }}">
                                <input type="hidden" class="transaction_purpose" name="transaction_purpose" value="{{ $post_data['transaction_purpose'] }}">
                                <input type="hidden" class="notes" name="notes" value="{{ $post_data['notes'] }}">
                                <input type="hidden" class="student_id" name="student_id" value="{{ $post_data['student_id'] }}">
                                <input type="hidden" class="invoice_id" name="invoice_id" value="{{ $post_data['invoice_id'] }}">
          
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="d-flex justify-content-between my-3 mx-2">
                                        <a href="/payment/fee" class="btn btn-default">Back</a>
                                       <button class="btn btn-primary btn-sm" type="submit">Pay Now (${{ $post_data['total_amount'] }})</button>
                                    </div>
                                </div>  
                            </form>
        </div>
    </section>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
   
    var $form = $(".require-validation");
   
    $('form.require-validation').bind('submit', function(e) {
        var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
  
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
   
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
  
  });
  
  function stripeResponseHandler(status, response) {
    // console.log(response); return false; 
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
               
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
   
});
</script>
</x-parent-layout>