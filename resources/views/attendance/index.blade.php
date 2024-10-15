<x-dashboard.teacher-layout>
    <x-slot name='title'>Attendance - Dreamers Academy</x-slot>
        <div class="body-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                            <div class="card-body px-4 py-3">
                                <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">All Student Attendance</h4>
                                    <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                        <li class="breadcrumb-item" aria-current="page">Attendance</li>
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
                                @if (Auth::guard('web')->user()->can('attendance.add'))
                                    <a href="/attendance/create" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
                                    <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add New</span>
                                    </a>
                                @endif
                            </div>
                            <div class="card-body table-responsive overflow-auto">
                                <!-- Table with stripped rows -->
                                <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'attendance-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display text-nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Class</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Student</th>
                                            <th scope="col">Status</th>
                                            @if (Auth::guard('web')->user()->can('attendance.edit'))
                                                <th scope="col">Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendances as $attendance)
                                        <tr>
                                            <th scope="row">{{ $attendance->id }}</th>
                                            <td>{{ $attendance->class->name }}</td>
                                            <td>{{ $attendance->date }}</td>
                                            <td>{{ $attendance->student->name }}</td>
                                            <td>{{ $attendance->status == true ? 'Present' : 'Absent' }}</td>
                                            @if (Auth::guard('web')->user()->can('attendance.edit'))
                                                <td>
                                                    <a href="/attendance/{{$attendance->id}}/edit" class="text-info edit">
                                                        <i class="ti ti-edit fs-5"></i>
                                                    </a>
                                                </td>
                                            @endif
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
    <script src="{{asset('assets/js/attendance/attendance-1.0.0.js')}}"></script>
</x-dashboard.teacher-layout>