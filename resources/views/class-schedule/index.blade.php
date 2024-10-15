<x-dashboard.admin-layout>
    <x-slot name='title'>Class Schedules - Dreamers Academy</x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                        <h4 class="fw-semibold mb-8">Class Schedule</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Class Schedule List</li>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="d-flex justify-content-end mt-3 me-4">
                        @if (Auth::guard('web')->user()->can('class_schedule.add'))
                            <a class="btn btn-primary" href="/class-schedule/create">
                                <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add New</span>
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                       <div class="table-responsive">
                        <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'class-schedule-datatable' : 'basic-datatable' }}"
                            class="table border table-striped table-bordered display table-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Class</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class_schedules as $class_schedule)
                                <tr>
                                    <td>
                                        <a @if (Auth::guard('web')->user()->can('class_schedule.edit')) href="/class-schedule/{{$class_schedule->class_id}}/edit?day={{$class_schedule->day}}" @endif>
                                            {{ $class_schedule->class->name }}
                                        </a>
                                    </td>
                                    <td>{{ $class_schedule->day }}</td>
                                    <td>{{ date('h:i a', strtotime($class_schedule->time)) }}</td>
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
    <script src="{{asset('assets/js/class-schedule/index-1.0.0.js')}}"></script>
</x-dashboard.admin-layout>