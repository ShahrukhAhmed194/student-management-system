<x-dashboard.admin-layout>
    <x-slot name='title'>Class Details - Dreamers Academy</x-slot>
    <style>
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple {
            line-height: 22px;
        }
    </style>
      <!-- Main wrapper -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">Class Details </h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Class Details</li>
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
                
            </div>
        </div>

        <div class="accordion mb-4" id="accordionExample">
            <div class="accordion-item" >
                <h2 class="accordion-header" id="headingTwo">
                    <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo"
                    aria-expanded="false"
                    aria-controls="collapseTwo"
                    >
                    Search Filter
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body h-auto">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="student_name" class="form-label">Student Name</label>
                                <input type="text" id="student_name" name="student_name" class="form-control" onfocusout="addParamsToUrl('student_name', this.value)">
                            </div>
                            <div class="col-md-2">
                                <label for="teacher_id" class="form-label">Teacher Name</label>
                                <select id="teacher_id" name="teacher_id" class="form-select select2" onchange="addParamsToUrl('teacher_id', this.value)">
                                    <option value="">Select Teacher</option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" >{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" id="student_id" name="student_id" class="form-control" onfocusout="addParamsToUrl('student_id', this.value)">
                            </div>
                            <div class="col-md-2">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" id="date" name="date" class="form-control" onfocusout="addParamsToUrl('date', this.value)">
                            </div>
                            <div class="col-md-2">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" id="time" name="time" class="form-control" onfocusout="addParamsToUrl('time', this.value)">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-primary" style="margin-top: 33px" onclick="location.reload();">SEARCH</button>
                                <a href="/class-details" class="btn btn-outline-info" style="margin-top: 33px">Clear</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body table-responsive">
                        <!-- Table with stripped rows -->
                        <table
                            id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'classdetails-datatable' : 'basic-datatable' }}"
                            class="table border table-striped table-bordered display table-responsive" style="width: 100%"
                            >
                            <thead>
                                <tr>
                                    <th scope="col">Student Info</th>
                                    <th scope="col">Class Name</th>
                                    <th scope="col">Instructor</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Attendance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($classes != '')
                                    @foreach($classes as $class)
                                    <tr class="classDetails">
                                        <td><b class="text-primary">{{ $class->studentName }}</b><br>
                                            <i class="ti ti-mail"></i>&nbsp; {{ $class->email }},<br>
                                            <i class="ti ti-user"></i>&nbsp; {{ $class->student_id }},<br>
                                            <i class="ti ti-phone"></i>&nbsp; {{ $class->phone }}&nbsp;
                                            <a href="tel:{{ $class->phone }}" class="btn btn-info btn-sm justify-content-center callButton" style="font-size: 8px; font-weight: bold;">
                                                <i class="ti ti-phone-outgoing"></i> &nbsp;Call 
                                            </a>
                                            <input type="hidden" name="student_id" value="{{$class->std_id}}">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="phone" value="{{ $class->phone }}">
                                        </td> 
                                        <td>{{ $class->className }}</td>
                                        <td>{{ $class->instructor }}</td>
                                        <td>{{ $class->day }}</td>
                                        <td>{{ date("h:i A", strtotime($class->time)) }}</td>
                                        <td>
                                            @if($class->status == 1)
                                            <span class="badge bg-success" > Present</span>
                                            @elseif(is_null($class->status))
                                            <span class="badge bg-warning" > Not Started Yet</span>
                                            @else
                                            <span class="badge bg-danger" >Absent</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </div>

  <script src="{{asset('assets/js/searchParams-1.0.0.js')}}"></script>
  <script src="{{asset('assets/js/class/class-details-1.2.0.js')}}"></script>
</x-dashboard.admin-layout>