<x-dashboard.admin-layout>
    <x-slot name='title'>Classes - Dreamers Academy</x-slot>
    
      <!-- Main wrapper -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">Classes</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Classes</li>
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
                    @if (Auth::guard('web')->user()->can('classes.add'))
                        <a href="/class/create" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
                        <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add New</span>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table
                      id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'classes-datatable' : 'basic-datatable' }}"
                      class="table border table-striped table-bordered display table-responsive" style="width: 100%"
                    >
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">Coordinator</th>
                                <th scope="col">Track</th>
                                <th scope="col">Level</th>
                                <th scope="col">Status</th>
                                <th class="text-center">Notification</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                            <tr>
                                <th scope="row">{{ $class->id }}</th>
                                <td>
                                    <a @can('classes.students') href="/class-students/{{$class->id}}" @endcan>
                                        {{ $class->name }}
                                    </a>
                                </td>
                                <td>{{ $class->teacher->name }}</td>
                                <td>{{ (!empty($class->coordinator->name) ? $class->coordinator->name : '') }}</td>
                                <td>{{ $class->track->track_num }}</td>
                                <td>{{ $class->level->level_num }}</td>
                                <td>{{ $class->status == 1? 'Active':'Inactive' }}</td>
                                <td class="text-center">{{ $class->notif_enable == 1? 'Yes':'No' }}</td>
                                <td class="text-center">
                                    @if (Auth::guard('web')->user()->can('classes.edit'))
                                        <a href="/class/{{$class->id}}/edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                    @endif
                                </td>
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
            
            $("#classes-datatable").DataTable({
            dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
            buttons: ["excel", "pdf", "print"],
            buttons: [
                {
                    extend: "excel",
                    title: "Classes",
                    text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                    titleAttr: 'Classes Excel File',
                    footer: true,
                    messageTop: 'Classes Report',
                    className: "btn-sm btn-sm btn-success",
                },
                {
                    extend: "print",
                    title: "Classes",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                    titleAttr: 'Classes Excel File',
                    footer: true,
                    messageTop: 'Classes Report',
                    className: "btn-sm btn-sm btn-primary",
                },
                {
                    extend: "pdf",
                    title: "Classes",
                    text: '<i class="ti ti-file-text"></i> PDF',
                    titleAttr: 'Classes PDF File',
                    footer: true,
                    messageTop: 'Classes Report',
                    className: "btn-sm btn-sm btn-secondary",
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
            $(
            ".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel"
            ).addClass("btn btn-primary mr-1");
            });
    </script>
</x-dashboard.admin-layout>