<x-dashboard.admin-layout>
    <x-slot name='title'>All Students - Dreamers Academy</x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                        <div class="row align-items-center">
                        <div class="col-9">
                            <h4 class="fw-semibold mb-8">All Students</h4>
                            <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">All Students</li>
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
                    <div class="card-body table-responsive overflow-auto">
                        <!-- Table with stripped rows -->
                        <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'allstudents-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td scope="row">{{ $student->id }}</td>
                                    <td>
                                        <a @can('students.edit') href="/student-edit/{{$student->id}}" @endcan>
                                            {{ $student->name }}
                                        </a>
                                    </td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->user_name }}</td>
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
    <script src="{{asset('assets/js/students/print-file-1.0.0.js')}}"></script>
</x-dashboard.admin-layout>