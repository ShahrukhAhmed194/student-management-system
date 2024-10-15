<x-dashboard.admin-layout>
    <x-slot name='title'>Bkash Transactions - Dreamers Academy</x-slot>

    <div class="container-fluid">
        <x-inc.breadcrumb title="Bkash Transactions" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive overflow-auto">
                        <table id="datatable" class="table border table-striped table-bordered display table-responsive datatable-data">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Customer Number</th>
                                    <th>Transaction ID</th>
                                    <th>Transaction type</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Reference</th>
                                    <th>Date Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $('.datatable-data').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('bkash.data') }}",
                    type: "GET",
                },
                order: [
                    [0, 'Desc']
                ],
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'debitMSISDN',
                        name: 'debitMSISDN',
                    },
                    {
                        data: 'trxID',
                        name: 'trxID',
                    },
                    {
                        data: 'transactionType',
                        name: 'transactionType',
                        searchable: false,
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                    },
                    {
                        data: 'currency',
                        name: 'currency',
                    },
                    {
                        data: 'transactionReference',
                        name: 'transactionReference',
                    },
                    {
                        data: 'date',
                        name: 'date',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'transactionStatus',
                        name: 'transactionStatus',
                    },
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: false,
                        searchable: false,
                    },
                ]
            });
        </script>
    </x-slot>

</x-dashboard.admin-layout>