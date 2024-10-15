<x-admin-layout>
    <style>
        .dataTables_wrapper .dataTables_paginate {
            font-size: 12px;
        }
    </style>
    <div class="pagetitle">
        <h1>Quizzes</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">All Quizzes</h5>
                            @if (Auth::guard('web')->user()->can('quiz.add'))
                            <a class="btn btn-primary" href="/quiz/create">Add New</a>
                            @endif
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table {{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'quiz-datatable' : 'datatable' }}" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Quiz Link</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quizzes as $quiz)
                                <tr>
                                    <th scope="row">{{ $quiz->id }}</th>
                                    <td>
                                        <a href="{{ $quiz->form_link }}" target="_blank">
                                            {{ $quiz->form_link }}
                                        </a>
                                    </td>
                                    <td>
                                        @if (Auth::guard('web')->user()->can('quiz.edit'))
                                            <a href="/quiz/{{$quiz->id}}/edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endif
                                    </td>
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
</x-admin-layout>
<script>
$(document).ready(function() {
    
    $('.quiz-datatable').DataTable({
        responsive: false,
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        aaSorting: [[0, "desc"]],
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
                targets: 2,
                className: "text-center",
            },
        ],
        buttons: [
            {
                extend: "excel",
                title: "Quiz",
                text: '<i class="bi bi-file-earmark-excel"></i>',
                titleAttr: 'Quiz Excel File',
                footer: true,
                messageTop: 'Quiz Report',
                className: "btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Quiz",
                text: '<i class="bi bi-printer-fill"></i>',
                titleAttr: 'Quiz Excel File',
                footer: true,
                messageTop: 'Quiz Report',
                className: "btn-sm btn-success",
            },
            {
                extend: "pdf",
                title: "Quiz",
                text: '<i class="bi bi-file-earmark-pdf"></i>',
                titleAttr: 'Quiz PDF File',
                footer: true,
                messageTop: 'Quiz Report',
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