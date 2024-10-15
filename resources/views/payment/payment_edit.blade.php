<x-admin-layout>
    <x-slot name="style">
        <!-- start Select2 css -->
        <link rel="stylesheet" href="{{ asset('assets/modernize/libs/select2/dist/css/select2.min.css') }}">
        <!-- close Select2 css -->
    </x-slot>
    <div class="pagetitle">
        <h1 class="text-center">Payment Page </h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
            <form class="row g-3" action="{{ url('/update-payment-by-admin') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Payment</h5>
                        <!-- Multi Columns Form -->
                        
                            <div class="row mt-3">
                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="student_id" class="form-label">Student</label>
                                <select id="student_id" name="student_id" class="form-select select2" required>
                                    <option value="">Select Student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->studentID }}" @if($student->studentID == $getPayment->student->id) selected @endif >{{ $student->name . ' - ' . $student->student_id }} @if($student->status != 1) (Inactive) @endif </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row mt-3">
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="fees" class="form-label">Amount</label>
                                <input type="text" id="fees" name="fees" class="form-control" value="{{ $getPayment->fees }}" >
                                @error('fees')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="date" class="form-label">Date </label>
                                <input type="date" id="date" name="date" class="form-control" value="{{ $getPayment->date }}" >
                                @error('date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row mt-3">
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="transaction_type" class="form-label">Transaction Type</label>
                                <select id="transaction_type" name="transaction_type" class="form-select" >
                                    <option value="">Select Type</option>
                                    <option value="bank" {{ (($getPayment->transaction_type == 'bank') ? 'selected' : '') }}>Bank</option>
                                    <option value="bkash" {{ (($getPayment->transaction_type == 'bkash') ? 'selected' : '') }}>Bkash</option>
                                    <option value="nagad" {{ (($getPayment->transaction_type == 'nagad') ? 'selected' : '') }}>Nagad</option>
                                    <option value="stripe" {{ (($getPayment->transaction_type == 'stripe') ? 'selected' : '') }}>Stripe</option>
                                    <option value="others" {{ (($getPayment->transaction_type == 'others') ? 'selected' : '') }}>Others</option>
                                </select>
                                @error('transaction_type')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <?php
                            $for_months = json_decode($getPayment->for_month);

                            ?>
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="for_month" class="form-label">For the Month </label>
                                 <select id="for_month" name="for_month[]" class="form-select  placeholder-single"  multiple data-placeholder="select month">
                                    <option value=""></option>
                                    @foreach($months as $month)
                                    @if(empty($for_months))
                                    <option value="{{ $month }}">{{ $month }}</option>
                                    @else
                                    <option value="{{ $month }}"{{in_array($month, $for_months) ? 'selected' : ''}} >{{ $month }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('installment')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row mt-3">
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="transaction_id" class="form-label">Transaction ID</label>
                                <input type="text" id="transaction_id" name="transaction_id" class="form-control" value="{{ $getPayment->transaction_id }}" >
                                @error('transaction_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="installment" class="form-label">Installment </label>
                                <input type="text" id="installment" name="installment" class="form-control" value="{{ $getPayment->installment }}" readonly>
                                @error('installment')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <input type="checkbox" name="enable_installment" id="enable_installment" onclick="makeInstallmentEditable()" unchecked>
                                <label for="enable_installment" class="form-label">Enable</label>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="transaction_purpose" class="form-label">Purpose</label>
                                <select id="transaction_purpose" name="transaction_purpose" class="form-select" >
                                    <option value="">Select purpose</option>
                                    <option value="monthly-fee" {{ ($getPayment->transaction_purpose == 'monthly-fee') ? 'selected' : '' }}>Monthly-fee</option>
                                    <option value="admission-fee" {{ ($getPayment->transaction_purpose == 'admission-fee') ? 'selected' : '' }}>Admission-fee</option>
                                    <option value="robotics-kit" {{ ($getPayment->transaction_purpose == 'robotics-kit') ? 'selected' : '' }}>Robotics-Kit</option>
                                    <option value="others" {{ ($getPayment->transaction_purpose == 'others') ? 'selected' : '' }}>Others</option>
                                </select>
                                @error('transaction_purpose')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row mt-3">
                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" name="notes" id="notes" rows="3" >{{ $getPayment->notes }}</textarea>
                                @error('notes')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                            <div class="row mt-3">
                            <div class="col-md-4">
                                <input type="checkbox" name="send_confirmation" id="send_confirmation" value="{{ $getPayment->send_confirmation }}" {{ (($getPayment->send_confirmation == 1) ? 'checked' : '') }}>
                                <label for="send_confirmation" class="form-label">Send Confirmation</label>
                            </div>
                            </div>
                            <input type="hidden" name="invoice_id" value="">
                            <input type="hidden" name="id" value="{{ $getPayment->id }}">
                        <!-- End Multi Columns Form -->
                    </div>
                </div>
                <div class="card">
                            <div class="d-flex justify-content-between my-3 mx-2">
                                <a href="/payment-history" class="btn btn-default">      Back
                                </a>
                                <div class="float-end">
                                    <button type="submit" name="invalid" class="btn btn-danger" value="invalid">Invalid</button> 
                                   <button type="submit" class="btn btn-primary">Update Payment</button>
                                    @if(can('payment_delete'))
                                        <button type="button" class="btn btn-danger"
                                                data-route="{{ route('payment.delete', ['id' => encrypt($getPayment->id)]) }}"
                                                data-action="confirm" data-method="post"
                                                data-title="Want To delete this payment?"
                                                data-text="Are You Sure !!!, You Wont Be Able To Undo...">
                                            Delete payment
                                        </button>
                                    @endif
                               </div>
                            </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </section>

    <x-slot name="script">
        <!-- start select2 js -->
        <script src="{{ asset('assets/modernize/libs/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets/modernize/libs/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/modernize/js/forms/select2.init.js') }}"></script>

        <script src="{{asset('assets/js/payment/add-payment-2.1.1.js')}}"></script>

        @if(can('payment_delete'))
            <script>
                $(document).on('click','[data-action="confirm"]',function(e){
                    e.preventDefault();
                    var $this = $(this);
                    if($(this).data('title')){
                        var title = $(this).data('title');
                    }else{
                        var title = 'Want To delete this payment?';
                    }
                    if($(this).data('text')){
                        var text = $(this).data('text');
                    }else{
                        var text = "Are You Sure !!!, You Wont Be Able To Undo...";
                    }
                    Swal.fire({
                        title:title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#30d689",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fireAjax($(this).data('route'), $(this).data('method') ?? 'get');
                        }
                    });
                });
            </script>
            <script>
                function fireAjax(url,type='get',data={}){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: type,
                        url: url,
                        data: data,
                        success: function(response){
                            toastr[`${ response.status }`](`${ response.message }`);
                            if( response.status === 'success' ){
                                setTimeout(function () {
                                    return window.location.href = response.url
                                }, 1000);
                            }
                        },
                    });
                }
            </script>
        @endif
    </x-slot>
</x-admin-layout>