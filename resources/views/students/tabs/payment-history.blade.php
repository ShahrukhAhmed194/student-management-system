<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="px-4 py-3 border-bottom">
                <h5 class="card-title fw-semibold mb-0 lh-sm">Payment History</h5>
            </div>
            <div class="card-body table-responsive overflow-auto">
                <table id="basic-datatable" class="table border table-striped table-bordered display table-responsive ">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th>Date</th>
                            <th>Fee</th>
                            <th>Currency</th>
                            <th>Transaction Type</th>
                            <th>Transaction ID</th>
                            <th>Transaction Purpose</th>
                            <th>For the Month</th>
                            <th>Status</th>
                            <th>Send Confirmation</th>
                            <th>Note</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lastMonthAllPayments as $index => $value)
                            <tr>
                                <td>{{++$index}}</td>
                                <td>{{ $value->date }}</td>
                                <td>{{ $value->fees }}</td>
                                <td>{{ $value->currency }}</td>
                                <td>{{ $value->transaction_type }}</td>
                                <td>{{ $value->transaction_id }}</td>
                                <td>{{ ucfirst($value->transaction_purpose) }}</td>
                                <td>@php 
                                    $showMonth = '';
                                    if($value->for_month){
                                    $for_months = json_decode($value->for_month, true); 
                                        foreach ($for_months as $month){
                                            $showMonth.=  $month .', ';
                                        }
                                        echo rtrim($showMonth, ', ');
                                    }
                                    @endphp 
                                </td>
                                <td>{{ $value->payment_status }}</td>
                                <td>{{ ($value->send_confirmation == 1) ? 'Yes' : 'No' }}</td>
                                <td>{{ (!empty($value->notes) ? $value->notes : '')}}</td>
                                <td>@if (Auth::guard('web')->user()->can('payment.list'))
                                        <a target="_blank" href="/payment/{{ $value->id }}/invoice">view</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card  mt-3">
            <div class="card-body p-3">
                <a class="btn btn-light float-start" href="/students">Back</a>
            </div>
          </div>
    </div>
</div>
<script src="{{ asset('assets/modernize/js/datatable/datatable-advanced.init.js') }}"></script>