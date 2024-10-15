<x-admin-layout>
     <style>
        .dataTables_wrapper .dataTables_paginate {
            font-size: 12px;
        }
    </style>
    <div class="pagetitle">
        <h1>Map Recordings</h1>
    </div><!-- End Page Title -->
    <div class="loader-div">
        <img class="loader-img" src="{{asset('assets/img/trial-class-registration/loader.gif')}}" style="height: 50%;width: 50%;" />
    </div> 
    <section class="section">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-3 text-right">
                            <a class="btn btn-info text-white" href="/passed-recording">Passed Recording</a>
                            <a class="btn btn-success text-white" href="/add-new-session">Add Missing Session</a>
                            {{-- <a class="btn btn-primary" href="/session/create">Create Session</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-body table-responsive">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">Search Filter</h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="meeting_date" >Meeting Date</label>
                                <input type="date" name="meeting_date" id="meeting_date" class="form-control" onfocusout="addParamsToUrl('date', this.value)">
                            </div>
                            <div class="col-lg-4">
                                <label for="teacher_email" >Teacher Email</label>
                                <input type="email" name="teacher_email" id="teacher_email" class="form-control" onfocusout="addParamsToUrl('email', this.value)">
                            </div>
                            <div class="col-lg-4 mt-4 pt-2">
                                <button class="btn btn-outline-primary" onclick="location.reload();">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card overflow-auto">
            <div class="card-body">
                <div class="d-flex justify-content-between my-3 mx-2">
                    <h5 class="">Mapping Live Recordings</h5>
                </div>
                <table class="table text-center {{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'recording-datatable' : 'datatable' }}" style="width: 100%">
                    <thead>
                        <tr>
                            <th scope="col">Meeting ID</th>
                            <th scope="col">Email</th>
                            <th scope="col">Meeting Date</th>
                            <th scope="col">Meeting Started</th>
                            <th scope="col">Meeting Ended</th>
                            <th scope="col">Session Information</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($recordings))
                        <form action="{{route('update-live-video')}}" method="POST">
                            @csrf
                            @foreach($recordings as $key => $recording)
                                <tr id="row_{{$key}}">
                                    <td>{{$recording->meeting_id}}<input type="hidden" name="recordings[{{$key}}][meeting_id]" value="{{$recording->meeting_id}}"></td>
                                    <td>{{$recording->topic}}<input type="hidden" name="recordings[{{$key}}][topic]" value="{{$recording->topic}}"></td>
                                    <td>{{date('dM, Y', strtotime($recording->start_time))}}<input type="hidden" name="recordings[{{$key}}][meeting_date]" value="{{$recording->start_time}}"></td>
                                    <td>{{date('h:i A', strtotime($recording->recording_start))}}<input type="hidden" name="recordings[{{$key}}][recording_start]" value="{{$recording->recording_start}}"></td>
                                    <td>{{date('h:i A', strtotime($recording->recording_end))}}<input type="hidden" name="recordings[{{$key}}][recording_end]" value="{{$recording->recording_end}}"></td>
                                    <td class="text-center"><select id="session_id_{{$key}}" name="recordings[{{$key}}][session_id]" >
                                        <option value="" selected disabled>Select Session</option>
                                        @foreach ($sessions as $session)
                                        <option value="{{$session->id}}">{{$session->teacher->name}};&nbsp; <b>Date:</b> &nbsp;{{ $session->session_date }};&nbsp; <b>Started:</b>&nbsp; {{date('h:i A', strtotime($session->session_started))}};&nbsp; <b>Ended:</b>&nbsp; {{date('h:i A', strtotime($session->session_ended))}} </option>
                                        @endforeach   
                                    </select><br>
                                    <input type="checkbox" name="recordings[{{$key}}][is_trial]" id="is_trial_{{$key}}" value="1">
                                    <label for="is_trial_{{$key}}">Select as trial class</label>

                                    <div id="session_info_error_{{$key}}" class="text-danger d-none">Please Provide session information before submission.</div>
                                    </td>
                                    <td><span onclick="validateSessionInfo( {{$recording->id}}, {{$key}}, '{{$recording->vimeo_embed_html}}' )" class="btn btn-primary btn-sm">Submit</span></td>
                                    <input type="hidden" name="recordings[{{$key}}][recording_id]" value="{{ $recording->id }}">
                                    <input type="hidden" name="recordings[{{$key}}][vimeo_embed_html]" value="{{$recording->vimeo_embed_html}}">
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                            <div class="text-right"><button type="submit" class="btn btn-primary">Submit All</button></div>
                        </form>
            </div>
        </div>
    </section>
    <link href="{{asset('assets/css/loader-1.0.0.css')}}" rel="stylesheet">

    <script src="{{asset('assets/js/sessions/recording-maping-2.3.0.js')}}"></script>
</x-admin-layout>
<script>
$(document).ready(function() {

    $('.recording-datatable').DataTable({
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
                targets: 6,
                className: "text-center",
            },
        ],
        buttons: [
            {
                extend: "excel",
                title: "Recording",
                text: '<i class="bi bi-file-earmark-excel"></i>',
                titleAttr: 'Recording Excel File',
                footer: true,
                messageTop: 'Recording Report',
                className: "btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Recording",
                text: '<i class="bi bi-printer-fill"></i>',
                titleAttr: 'Recording Excel File',
                footer: true,
                messageTop: 'Recording Report',
                className: "btn-sm btn-success",
            },
            {
                extend: "pdf",
                title: "Recording",
                text: '<i class="bi bi-file-earmark-pdf"></i>',
                titleAttr: 'Recording PDF File',
                footer: true,
                messageTop: 'Recording Report',
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