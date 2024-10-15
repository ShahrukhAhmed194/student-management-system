<x-dashboard.admin-layout>
    <x-slot name='title'>Projects - Dreamers Academy</x-slot>
    
      <!-- Main wrapper -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">All Projects</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Projects</li>
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
                    @if (Auth::guard('web')->user()->can('projects.add'))
                        <a href="/project/create" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
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
                            <th scope="col">Learning Outcomes</th>
                            <th scope="col">Link Teacher</th>
                            <th scope="col">Link SB</th>
                            <th scope="col">Link SA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <th scope="row">{{ $project->id }}</th>
                            <td>
                                <a @if (Auth::guard('web')->user()->can('projects.edit')) href="/project/{{$project->id}}/edit" @endif>
                                    {{ $project->name }}
                                </a>
                            </td>
                            <td>{{ $project->learning_outcomes }}</td>
                            <td>{{ $project->link_teacher }}</td>
                            <td>{{ $project->link_student_before }}</td>
                            <td>{{ $project->link_student_after }}</td>
                            
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
            
            $(".project-datatable").DataTable({
            dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
            buttons: ["excel", "pdf", "print"],
            buttons: [
                {
                    extend: "excel",
                    title: "Projects",
                    text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                    titleAttr: 'Projects Excel File',
                    footer: true,
                    messageTop: 'Projects Report',
                    className: "btn-sm btn-sm btn-success",
                },
                {
                    extend: "print",
                    title: "Projects",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                    titleAttr: 'Projects Excel File',
                    footer: true,
                    messageTop: 'Projects Report',
                    className: "btn-sm btn-sm btn-primary",
                },
                {
                    extend: "pdf",
                    title: "Projects",
                    text: '<i class="ti ti-file-text"></i> PDF',
                    titleAttr: 'Projects PDF File',
                    footer: true,
                    messageTop: 'Projects Report',
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