<x-parent-layout>
    <div class="pagetitle">
        <h1 class="text-center">Make Payment</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <form class="row g-3 mt-2" action="{{ url('/pay') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <!-- Multi Columns Form -->
                                <input type="hidden" id="transaction_type" name="transaction_type" value="Online">
                                <div class="col-md-12 mt-3">
                                    <span style="color:#e41111">*</span>
                                    <label for="student_id" class="form-label">Child</label>
                                    <select id="student_id" name="student_id" class="form-select choices" onchange="autoFillData()">
                                        <option value="">Select Child</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @error('bkash_student_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <span style="color:#e41111">*</span>
                                    <label for="fees" class="form-label">Amount</label>
                                    <input type="number" id="fees" name="fees" class="form-control">
                                    @error('fees')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @error('bkash_fees')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <span style="color:#e41111">*</span>
                                    <label for="installment" class="form-label">Installment</label>
                                    <input type="number" id="installment" name="installment" class="form-control">
                                    @error('installment')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @error('bkash_installment')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <span style="color:#e41111">*</span>
                                    <label for="transaction_purpose" class="form-label">Purpose</label>
                                    <select id="transaction_purpose" name="transaction_purpose" class="form-select">
                                        <option value="">Select purpose</option>
                                        <option value="monthly-fee">Monthly-fee</option>
                                        <option value="admission-fee">Admission-fee</option>
                                        <option value="others">Others</option>
                                    </select>
                                    @error('transaction_purpose')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @error('bkash_transaction_purpose')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <span style="color:#e41111">*</span>
                                    <label for="for_month" class="form-label">For the Month </label>
                                        <select id="for_month" name="for_month[]" class="form-select  placeholder-single" multiple data-placeholder="select month" onchange="fillUpBkashFormwithoutAgreement()">
                                        <option value=""></option>
                                        @foreach($months as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    @error('for_month')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @error('bkash_for_month')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="notes" class="form-label">Notes</label>
                                    <!-- <input type="text" name="address" class="form-control" id="inputAddres5s" placeholder="1234 Main St"> -->
                                    <textarea class="form-control" name="notes" rows="3"></textarea>
                                    @error('notes')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <input type="checkbox" id="agreement" name="agreement" value="1" unchecked onclick="fillUpBkashForm()">
                                    <label for="agreement">I agree to the 
                                        <a target="_blank" href="https://dreamersacademy.com.bd/terms-cond.html">Terms and Condition</a> &amp; 
                                        <a target="_blank" href="https://dreamersacademy.com.bd/return-policy.html">Return and Refund Policy</a>.
                                    </label>
                                    @error('agreement')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    @error('bkash_agreement')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="d-inline-flex justify-content-between my-3 mx-2">
                            <a href="/payment" class="btn btn-secondary">Back</a>
                           <button type="submit" class="btn btn-primary">Pay With Bank/Card</button>
                            </form>
                            <form action="{{ route('url-create') }}" method="POST">
                                @csrf
                                <input type="hidden" id="bkash_student_id" name="bkash_student_id">
                                <input type="hidden" id="bkash_fees" name="bkash_fees">
                                <input type="hidden" id="bkash_installment" name="bkash_installment">
                                <input type="hidden" id="bkash_transaction_type" name="bkash_transaction_type" value="Online">
                                <input type="hidden" id="bkash_transaction_purpose" name="bkash_transaction_purpose">
                                <input type="hidden" id="bkash_agreement" name="bkash_agreement" value="">
                                <input type="hidden" id="bkash_for_month" name="bkash_for_month">
                                <input type="hidden" id="bkash_notes" name="bkash_notes">
                                <button type="submit" class="btn text-light" style="background-color: #e2136e;" >Pay With BKash</button>
                            </form>
                        </div>
                    </div>
                </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"></div>
        </div>
    </section>
    <script src="{{asset('assets/js/payment/add-payment-2.1.1.js')}}"></script>    
    @section('custom-js')
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <!-- If you want to use the popup integration, -->
        <script>
            var obj = {};
            obj.cus_name = $('#customer_name').val();
            obj.cus_phone = $('#mobile').val();
            obj.cus_email = $('#email').val();
            obj.cus_addr1 = $('#address').val();
            obj.amount = $('#amount').val();
            obj.student_id = $('#student_id').val();
            $('#sslczPayBtn').prop('postdata', obj);
            (function(window, document) {
                var loader = function() {
                    var script = document.createElement("script"),
                        tag = document.getElementsByTagName("script")[0];
                    // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
                    script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
                    tag.parentNode.insertBefore(script, tag);
                };
                window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
            })(window, document);
        </script>
    @endsection
    <img src="{{URL::asset('assets/img/SSLCOMMERZ.png')}}" alt="profile Pic" height="200" width="100%">
</x-parent-layout>
