<x-dashboard.admin-layout>
    <x-slot name='title'>Trial Class Schedules- Dreamers Academy</x-slot>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">Trial Class Schedules</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Trial Class Schedules</li>
                            </ol>
                          </nav>
                        </div>
                        <div class="col-3">
                          <div class="text-center mb-n5">  
                            <img src="{{ asset('assets/modernize/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12">
              <div class="card">
                <div class="">
                    @if (Auth::guard('web')->user()->can('trialclass_schedule.add'))
                        <a href="/trial-class-schedule/create" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
                        <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add New</span>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table
                      id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'trialclass_schedule-datatable' : 'basic-datatable' }}"
                      class="table border table-striped table-bordered display table-responsive"
                    >
                    <thead>
                        <tr>
                            <th scope="col">Track</th>
                            <th scope="col">Teacher</th>
                            <th scope="col">Coordinator</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Available Seats</th>
                            <th scope="col">Country</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trial_class_schedules as $trial_class_schedule)
                        <tr>
                            <td>
                                <a @if (Auth::guard('web')->user()->can('trialclass_schedule.edit')) href="/trial-class-schedule/{{$trial_class_schedule->id}}/edit" @endif>
                                    @if ($trial_class_schedule->age_from == 7 && $trial_class_schedule->age_to == 8)
                                        Track 1
                                    @elseif($trial_class_schedule->age_from == 9 && $trial_class_schedule->age_to == 10)
                                        Track 2
                                    @elseif($trial_class_schedule->age_from >= 11 || $trial_class_schedule->age_to <= 16)
                                        Track 3
                                    @else
                                        Wrong Age Limit
                                    @endif
                                </a>
                            </td>
                            <td>{{ (!empty($trial_class_schedule->teacher->name) ? $trial_class_schedule->teacher->name : '') }}</td>
                            <td>{{ (!empty($trial_class_schedule->coordinator->name) ? $trial_class_schedule->coordinator->name : '') }}</td>
                            <td>{{ date('d M, Y', strtotime($trial_class_schedule->date)) }}</td>
                            <td>{{ date('h:i A', strtotime($trial_class_schedule->time)) }}</td>
                            <td>{{ $trial_class_schedule->available_seats }}</td>
                            <td>{{ $trial_class_schedule->country }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>

    <script>
         $(document).ready(function() {
            
            $("#trialclass_schedule-datatable").DataTable({
            dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
            buttons: ["excel", "pdf", "print"],
            buttons: [
                {
                    extend: "excel",
                    title: "Trial-class-Schedule",
                    text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                    titleAttr: 'Trial class schedule Excel File',
                    footer: true,
                    messageTop: 'Trial class Schedule Report',
                    className: "btn-sm btn-sm btn-success",
                },
                {
                    extend: "print",
                    title: "Trial class Schedule",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                    titleAttr: 'Trial class Schedule Excel File',
                    footer: true,
                    messageTop: 'Trial class Schedule Report',
                    className: "btn-sm btn-sm btn-primary",
                },
                {
                    extend: "pdf",
                    title: "Trial class Schedule",
                    text: '<i class="ti ti-file-text"></i> PDF',
                    titleAttr: 'Trial class Schedule PDF File',
                    footer: true,
                    messageTop: 'Trial class Schedule Report',
                    className: "btn-sm btn-sm btn-secondary",
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
            ],
            });
            $(
            ".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel"
            ).addClass("btn btn-primary mr-1");
            });
    </script>
</x-dashboard.admin-layout>