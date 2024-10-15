<x-admin-layout>
    <style>
       .dataTables_wrapper .dataTables_paginate {
           font-size: 12px;
       }
   </style>
   <div class="pagetitle">
       <h1>Missing Session</h1>
   </div><!-- End Page Title -->
 
   <section class="section">
       <div class="row">
           <div class="col-sm-12">
               <div class="card">
                   <div class="card-body">
                       <div class="mt-3 text-right">
                        <a class="btn btn-success text-white" href="/update-recording-list">Map Recording</a>
                        <a class="btn btn-info text-white" href="/passed-recording">Passed Recording</a>
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
                       <form action="/missing-session" method="get" >
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="date" >Meeting Date</label>
                                    <input type="date" name="date" id="date" class="form-control" value="{{ $allResults['date'] }}" onfocusout="addParamsToUrl('date', this.value)">
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
                <h5 class="">Missing Session</h5>
            </div>
            <table class="table text-center {{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'datatable' : 'datatable' }}" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Sl No</th>
                        <th scope="col" class="text-left">Class</th>
                        <th scope="col" class="text-left">Teacher</th>
                        <th scope="col" class="text-center">Time</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($allResults['getMissingSessionData']))
                        @foreach($allResults['getMissingSessionData'] as $key => $session)
                            <tr id="row_{{$key}}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-left"> {{ $session->name }} </td>
                                <td class="text-left"> {{ $session->teacherName }} </td>
                                <td class="text-center"> {{ $session->time }} </td>
                                
                                <td class="text-center">
                                    {{-- ?date=2023-07-08 --}}
                                    <a class="" href="/add-new-session?session_date={{ $allResults['date'] }}&session_started={{ $session->time }}&class_id={{$session->class_id}}&teacher_id={{$session->teacher_id}}">
                                        <i class="bi bi-plus"></i>
                                    </a>
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