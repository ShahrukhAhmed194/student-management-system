<x-dashboard.teacher-layout>
    <x-slot name='title'>Homework - Dreamers Academy</x-slot>
        <div class="body-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                            <div class="card-body px-4 py-3">
                                <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Student Homework</h4>
                                    <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Homework</li>
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
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card ">
                            <div class="">
                                @if(auth('web')->user()->can('homework.add'))
                                    <a href="/homework-create" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
                                        <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add New</span>
                                    </a>
                                @endif
                            </div>
                            <div class="card-body table-responsive overflow-auto">
                                <!-- Table with stripped rows -->
                                <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'assessment-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display text-nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Project</th>
                                            <th scope="col">Student</th>
                                            <th scope="col">Project Status</th>
                                            <th scope="col">Project Assesment</th>
                                            <th scope="col">Comments</th>
                                            @can('homework.edit')
                                                <th scope="col">Action</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Homeworks as $single)
                                            <tr>
                                                <th scope="row">{{ $single->id }}</th>
                                                <td>{{ $single->class->name }}</td>
                                                <td>{{ $single->project->name }}</td>
                                                <td>{{ $single->student->name }}</td>
                                                <td>{{ str_replace("_"," ", $single->project_status) }}</td>
                                                <td>{{ str_replace("_"," ", $single->project_assesment) }}</td>
                                                <td>{{ $single->comments }}</td>
                                                @can('homework.edit')
                                                <td>
                                                    <a href="/project-assesment/{{$single->id}}/edit" class="text-info edit">
                                                        <i class="ti ti-eye fs-5"></i>
                                                    </a>
                                                </td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="{{asset('assets/js/project/projectAssessment-1.0.0.js')}}"></script>
</x-dashboard.teacher-layout>