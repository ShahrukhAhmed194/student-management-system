    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendor/select2/css/select2.min-1.0.0.css" />



<style>
.header{
    display: none !important;
}
.footer{
    display: none !important;
}
</style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="pagetitle">
        <h1 class="text-center">Make Payment</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                <form class="row g-3 mt-2" action="{{ url('/online-payment') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger d-none mismatch-contact-msg">
                                Your contact number is not registered with Dreamers Academy
                            </div>
                                <input type="hidden" id="transaction_type" name="transaction_type" class="form-control" value="Online">
                                <div class="row mt-3">

                                    <div class="col-md-10">
                                        <label for="phone_number" class="form-label"><span style="color:#e41111">*</span> Contact Number (Registered)</label>
                                        <input type="text" id="phone_number" name="phone_number" class="form-control col-md-8" onkeyup="" required>
                                     </div>
                                     <div class="col-md-2">
                                     <label for="phone_number" class="form-label col-md-10">&nbsp;</label>
                                         <button type="button" class="btn btn-sm btn-info text-white" onclick="getParentInfoByPhone()" >Submit</button>
                                     </div>
                                    <small class="text-danger" style="font-size: 10px;">Phone number is required</small>
                                </div>
                              
                            <div class="col-md-12 mt-3 loadchild">
                               
                            </div>
                                
                            <div class="col-12">
                                <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
                                <input type="checkbox" id="agreement" name="agreement" value="1" required>
                                <label for="agreement">I agree to the 
                                    <a target="_blank" href="https://dreamersacademy.com.bd/terms-cond.html">Terms and Condition</a> &amp; 
                                    <a target="_blank" href="https://dreamersacademy.com.bd/return-policy.html">Return and Refund Policy</a>.
                                </label><br>
                            </div>
                                <!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <a href="/payment" class="btn btn-default">Back</a>
                           <button type="submit" class="btn btn-primary">Pay Now</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">

            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js">
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/select2/js/select2.min-1.0.0.js"></script>

    <script src="{{asset('assets/js/payment/add-payment-1.0.0.js')}}"></script>    

    
    <!-- If you want to use the popup integration, -->
    <script>
        $(document).ready(function(){
            $(".placeholder-single").select2();
        });

        function getParentInfoByPhone(){
            let fd = new FormData();
            let phone = $('#phone_number').val();
            fd.append("phone", phone);

            $.ajax({
                url: "/get-parentinfo-byphone",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data: fd,
                enctype: "multipart/form-data",
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response == 'notfound'){
                        $(".mismatch-contact-msg").removeClass('d-none').addClass('d-block');
                        $(".loadchild").html("");
                    }else{
                        $(".mismatch-contact-msg").addClass('d-none');
                        $(".loadchild").html(response);
                        $("#for_month").addClass("placeholder-single");
                        $(".placeholder-single").select2();
                    }
                },
                error: function (data){
                    console.log('fail');
                },
            });
        }
    </script>
    <img src="{{URL::asset('assets/img/SSLCOMMERZ.png')}}" alt="profile Pic" height="200" width="100%">

