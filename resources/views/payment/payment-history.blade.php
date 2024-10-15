<?php 
    use App\Models\Student;
    use App\Models\User;
?>
<x-admin-layout>
    <style>
        .dataTables_wrapper .dataTables_paginate {
            font-size: 12px;
        }
        .row{
            margin: 15px;
        }
    </style>
<div class="pagetitle">
    <h1>Payment History</h1>
</div>
<section class="section">
<div class="card">
    <form action="/filter-payment-history" method="POST" >
        @csrf
    <div class="row p-5">
        <div class="col-md-2">
            <label for="select-student" class="form-label">Student Name</label>
            <select id="select-student" name="student_id" class="form-select choices">
                <option value="">Select Student</option>
                @foreach($students as $student)
                    <option value="{{$student->id}}" {{$data['id'] == $student->id ? 'selected' : ''}}>
                        {{$student->name}} ({{$student->student_id}}) {{$student->status == 1 ? '' : '(Inactive)'}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="from_date" class="form-label">From Date</label>
            <input type="date" name="from_date" id="from_date" value="{{$data['from_date']}}" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="to_date" class="form-label">To Date</label>
            <input type="date" name="to_date" id="to_date" value="{{$data['to_date']}}" class="form-control">
        </div>
        <div class="col-md-2">
            <label for="transaction_type" class="form-label">Transaction Type</label>
            <select id="transaction_type" name="transaction_type" class="form-select choices">
                <option value="">Select Transaction Type</option>
                <option value="bank" {{ ($data['transaction_type'] == 'bank') ? 'selected' : '' }} >Bank</option>
                <option value="bkash" {{ ($data['transaction_type'] == 'bkash') ? 'selected' : '' }} >Bkash</option>
                <option value="nagad" {{ ($data['transaction_type'] == 'nagad') ? 'selected' : '' }} >Nagad</option>
                <option value="stripe" {{ ($data['transaction_type'] == 'stripe') ? 'selected' : '' }} >Stripe</option>
            </select>
        </div> 
        <div class="col-md-2">
            <label for="currency" class="form-label">Currency</label>
            <select id="currency" name="currency" class="form-select choices">
                <option value="">Select Currency</option>
                <option value="BDT" {{ ($data['currency'] == 'BDT') ? 'selected' : '' }}>BDT</option>
                <option value="USD" {{ ($data['currency'] == 'USD') ? 'selected' : '' }}>USD</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary" style="margin-top: 33px">SEARCH</button>
            <a href="/payment-history" class="btn btn-outline-info" style="margin-top: 33px">Clear</a>
        </div>
    </div>
</form>
</div>
</section>  
<section class="section">
<div class="card">
    <!-- Table with stripped rows -->
    <table class="table {{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'payments-datatable' : 'datatable' }}" style="width: 100%">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Fee</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Transaction Type</th>
                    <th scope="col">Transaction ID</th>
                    <th scope="col">Transaction Purpose</th>
                    <th scope="col">For the Month</th>
                    <th scope="col">Status</th>
                    <th scope="col">Send Confirmation</th>
                    <th scope="col">Note</th>
                    <th scope="col">Invoice</th>
                </tr>
            </thead>
            <tbody>
                 <?php 
                 foreach($lastMonthAllPayments as $value){
                    ?>
                    <tr>
                        <td>{{ $value->date }}</td>
                        <td>
                            <a @if(Auth::guard('web')->user()->can('payment.edit')) href="/payment-edit/{{$value->id}}" @endif>
                                {{ $value->student->user->name }}
                            </a>
                        </td>
                        <td>{{ $value->fees }}</td>
                        <td>{{ $value->currency }}</td>
                        <td>{{ $value->transaction_type }}</td>
                        <td>{{ $value->transaction_id }}</td>
                        <td>{{ $value->transaction_purpose }}</td>
                        <td>
                        @php 
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
                        <td>
                            {{ ($value->send_confirmation == 1) ? 'Yes' : 'No' }}
                        </td>
                        <td>{{ (!empty($value->notes) ? $value->notes : '')}}</td>
                        <td>
                            @if (Auth::guard('web')->user()->can('payment.list'))
                                <a target="_blank" href="/payment/{{ $value->id }}/invoice">view</a>
                            @endif
                        </td>
                    </tr>
                 <?php } ?>
            </tbody>
    </table>
    <!-- End Table with stripped rows -->
</div>
</section>
<script src="{{asset('assets/js/payment/payment-history-1.0.2.js')}}"></script>    
</x-admin-layout>
<script>
$(document).ready(function() {

    $('.payments-datatable').DataTable({
        responsive: false,
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        aaSorting: [[1, "desc"]],
        language: {
            searchPlaceholder: "Search",
            search: "",
        },
        columnDefs: [
            {
                bSortable: true,
                aTargets: [0],
            },
            {
                bSortable: false,
                targets: 6,
                className: "text-center",
            },
        ],
        buttons: [
            {
                extend: "excel",
                title: "Payment History",
                text: '<i class="bi bi-file-earmark-excel"></i>',
                titleAttr: 'Payment History Excel File',
                footer: true,
                messageTop: 'Payment History Report',
                className: "btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Payment History",
                text: '<i class="bi bi-printer-fill"></i>',
                titleAttr: 'Payment History Excel File',
                footer: true,
                messageTop: 'Payment History Report',
                className: "btn-sm btn-success",
            },
            {
                extend: "pdf",
                title: "Payment History",
                text: '<i class="bi bi-file-earmark-pdf"></i>',
                titleAttr: 'Payment History PDF File',
                footer: true,
                messageTop: 'Payment History Report',
                className: "btn-sm btn-success",
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
        ],
        scrollX: true,
        orderCellsTop: true,
        fixedHeader: true,
        lengthMenu: [
            [10, 20, 50, 100, 150, 200, 500],
            [10, 20, 50, 100, 150, 200, "All"],
        ],
        processing: true,
        sProcessing: "<span class='fas fa-sync-alt'></span>",
        serverSide: false,
    });
});
</script>
