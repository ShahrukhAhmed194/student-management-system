<x-admin-layout>
    <style>
       .dataTables_wrapper .dataTables_paginate {
           font-size: 12px;
       }
   </style>
   <div class="pagetitle">
       <h1>Passed Recordings</h1>
   </div><!-- End Page Title -->
 
   <section class="section">
       <div class="row">
           <div class="col-sm-12">
               <div class="card">
                   <div class="card-body">
                       <div class="mt-3 text-right">
                        <a class="btn btn-info text-white" href="/update-recording-list">Map Recording</a>
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
                       <form action="/passed-recording" method="get" >
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="meeting_date" >Meeting Date</label>
                                    <input type="date" name="meeting_date" id="meeting_date" class="form-control" value="{{ $allResults['meeting_date'] }}" onfocusout="addParamsToUrl('date', this.value)">
                                </div>
                                <div class="col-lg-4 mt-4 pt-2">
                                    <button type="submit" class="btn btn-outline-primary">Search</button>
                                </div>
                            </div>
                        </form>
                   </div>
               </div>
           </div>
       </div>
   </section>

   <section class="section">
    <div class="card overflow-auto">
        <div class="card-body">
            <div class="d-flex justify-content-between my-3 mx-2">
                <h5 class="">Passed Recordings {{ Auth::guard('web')->user()->can('report.download') }}</h5>
            </div>
            <table class="table text-center {{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'datatable' : 'datatable' }}" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Sl No</th>
                        <th scope="col">Teacher</th>
                        <th scope="col">Class</th>
                        <th scope="col">Session Date</th>
                        <th scope="col">Session Started</th>
                        <th scope="col">Session Ended</th>
                        <th scope="col">Recording</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($allResults['recordings']))
                        @foreach($allResults['recordings'] as $key => $recording)
                            <tr id="row_{{$key}}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-left"> {{ $recording->teacher->name }} </td>
                                <td class="text-left"> {{ $recording->sessionClass->name }} </td>
                                <td class="text-left"> {{ $recording->session_date }} </td>
                                <td class="text-left"> {{ date('h:i A', strtotime($recording->session_started)) }} </td>
                                <td class="text-left"> {{ date('h:i A', strtotime($recording->session_ended)) }} </td>
                                <td class="text-left"> 
                                    <?php if($recording->recording_link){ ?>
                                        <span class='badge badge-primary'>Yes</span>
                                    <?php }else{ ?>
                                        <span class='badge badge-warning'>No</span>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <a class="" href="/passed-recording-edit/{{ $recording->id }}"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
</x-admin-layout>