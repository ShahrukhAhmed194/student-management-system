<x-admin-layout>
        <!-- start Select2 css -->
        <link rel="stylesheet" href="{{ asset('assets/modernize/libs/select2/dist/css/select2.min.css') }}">
        <!-- close Select2 css -->
    <div class="pagetitle">
        <h1 class="text-center">Payment Page </h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form class="row g-3" action="{{ url('/add-payment-by-admin') }}" method="POST">
                        @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add Payment</h5>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <span style="color:#e41111">*</span>
                                        <label for="student_id" class="form-label">Student</label>
                                        <select id="student_id" name="student_id" class="form-select select2"  onchange="autoFillData()">
                                            <option value="">Select Child</option>
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
                                        <input type="text" id="fees" name="fees" value="{{old('fees')}}" class="form-control" >
                                        <small class="hint-text text-danger"></small>
                                        @error('fees')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <span style="color:#e41111">*</span>
                                        <label for="date" class="form-label">Date </label>
                                        <input type="date" id="date" name="date" class="form-control" value="{{ $today->format('Y-m-d') }}" >
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
                                            <option value="bank">Bank</option>
                                            <option value="bkash">Bkash</option>
                                            <option value="nagad">Nagad</option>
                                            <option value="stripe">Stripe</option>
                                            <option value="others">Others</option>
                                        </select>
                                        @error('transaction_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <span style="color:#e41111">*</span>
                                        <label for="for_month" class="form-label">For the Month </label>
                                            <select id="for_month" name="for_month[]" class="form-select  placeholder-single" multiple data-placeholder="select month">
                                            <option value=""></option>
                                            @foreach($months as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                        @error('for_month')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <span style="color:#e41111">*</span>
                                        <label for="transaction_id" class="form-label">Transaction ID</label>
                                        <input type="text" id="transaction_id" name="transaction_id" value="{{old('transaction_id')}}" class="form-control" >
                                        @error('transaction_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <span style="color:#e41111">*</span>
                                        <label for="installment" class="form-label">Installment </label>
                                        <input type="text" id="installment" name="installment" class="form-control" >
                                        @error('installment')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="enable_installment" id="enable_installment" value="on">
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <span style="color:#e41111">*</span>
                                        <label for="transaction_purpose" class="form-label">Purpose</label>
                                        <select id="transaction_purpose" name="transaction_purpose" class="form-select" >
                                            <option value="">Select purpose</option>
                                            <option value="monthly-fee">Monthly-fee</option>
                                            <option value="robotics-kit">Robotics-Kit</option>
                                            <option value="admission-fee">Admission-fee</option>
                                            <option value="others">Others</option>
                                        </select>
                                        @error('transaction_purpose')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea class="form-control" name="notes" id="notes" rows="3">{{old('notes')}}</textarea>
                                        @error('notes')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <input type="checkbox" name="send_confirmation" id="send_confirmation" value="1" checked>
                                        <label for="send_confirmation" class="form-label">Send Confirmation</label>
                                    </div>
                                </div>
                            <!-- End Multi Columns Form -->
                        </div>
                    </div>
                    <div class="card">
                        <div class="justify-content-between my-3 mx-2">
                            <a href="/payment-history" class="btn btn-default">Back</a>
                            <div class="float-end">
                                <button type="submit" name="invalid" class="btn btn-danger" value="invalid">Invalid</button>
                                <button type="submit" class="btn btn-primary">Add Payment</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </section>
    <script src="{{asset('assets/js/payment/add-payment-2.1.1.js')}}"></script>    
     <!-- start select2 js -->
     <script src="{{ asset('assets/modernize/libs/select2/dist/js/select2.full.min.js') }}"></script>
     <script src="{{ asset('assets/modernize/libs/select2/dist/js/select2.min.js') }}"></script>
     <script src="{{ asset('assets/modernize/js/forms/select2.init.js') }}"></script>
</x-admin-layout>
