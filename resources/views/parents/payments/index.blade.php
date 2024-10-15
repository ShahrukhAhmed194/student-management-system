<x-parent-layout>
    <div class="pagetitle">
        <h1>Payments</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">All Payments</h5>
                            {{-- <a class="btn btn-primary" href="/payment/fee">Make Payment</a> --}}
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Child</th>
                                    <th scope="col">Fee</th>
                                    <th scope="col">For The Month(s)</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Status</th>
                                    @if (Auth::guard('web')->user()->can('payment.list'))
                                        <th scope="col">Invoice</th>
                                    @endif
                                    @role('Admin|Super-Admin')
                                    <th scope="col">Action</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->date }}</td>
                                    <td>{{ $payment->student->user->name }}</td>
                                    <td>৳{{ $payment->fees }}</td>
                                    <?php
                                    for($i=0; $i < strlen($payment->for_month); $i++){
                                        $payment->for_month = trim($payment->for_month,'[]');
                                        $payment->for_month = str_replace('"','',$payment->for_month);
                                    }?>
                                    <td>{{ $payment->for_month }}</td>
                                    <td>{{ $payment->notes }}</td>
                                    <td>{{ $payment->payment_status }}</td>
                                    @if (Auth::guard('web')->user()->can('payment.list'))
                                        <td>
                                            <a href="/payment/{{$payment->id}}/invoice">view</a>
                                        </td>
                                    @endif
                                    @role('Admin|Super-Admin')
                                    <td>
                                        <a href="/payments/{{$payment->id}}/edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                    @endrole
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</x-parent-layout>