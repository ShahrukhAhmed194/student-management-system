<x-dashboard.admin-layout>
    <link rel="stylesheet" href="{{asset('assets/css/students/student-1.0.0.css')}}">
    <x-slot name='title'>{{$status}} Students - Dreamers Academy</x-slot>
    
    <div class="container-fluid">

        <x-inc.breadcrumb title="Students" breadcrumb="{{$status}} Students" />

        <div class="row">
            <div class="accordion" id="accordion_filter">
                <div class="accordion-item" >
                    <h2 class="accordion-header" id="accordion_search">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_search" aria-expanded="false" aria-controls="collapse_search">Search Here</button>
                    </h2>
                    <div id="collapse_search" class="accordion-collapse collapse" aria-labelledby="accordion_search" data-bs-parent="#accordion_filter">
                        <div class="accordion-body h-auto">
                            <div class="row">
                                <div class="col-md-2 col-sm-12">
                                    <label for="email" class="form-label">Student Email</label>
                                    <input type="text" id="email" name="email" class="form-control" value="{{old('email')}}" onfocusout="addParamsToUrl('email', this.value)">
                                    @error('email')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{old('phone')}}" onfocusout="addParamsToUrl('phone', this.value)">
                                    @error('phone')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="start_date" class="form-label">Due Date Start</label>
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{old('start_date')}}" onfocusout="addParamsToUrl('start_date', this.value)">
                                    @error('start_date')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="end_date" class="form-label">Due Date End</label>
                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{old('end_date')}}" onfocusout="addParamsToUrl('end_date', this.value)">
                                    @error('end_date')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                    @enderror
                                    @error('date_range')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="due_installments" class="form-label">Due Installment(s)</label>
                                    <input type="text" id="due_installments" name="due_installments" class="form-control" value="{{old('due_installments')}}" onfocusout="addParamsToUrl('due_installments', this.value)">
                                    @error('due_installments')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-2 col-sm-12 text-center">
                                    <label for="is_due" class="form-label">Is Due Date Empty?</label><br>
                                    <input type="checkbox" name="is_due" id="is_due" onclick="showIsDueInUrl()">
                                    <input type="hidden" id="is_due_hidden" value="1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10"></div>
                                <div class="col-md-1 col-sm-12 d-flex justify-content-end">
                                    <button  class="btn btn-outline-primary" style="margin-top: 30px" onclick="location.reload();">Generate</button>
                                </div>
                                <div class="col-md-1 col-sm-12 d-flex justify-content-start">
                                    <a href="{{route('students.index')}}" class="btn btn-outline-danger float-end" style="margin-top: 30px" title="Reset">
                                        <i class="ti ti-reload"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card ">
                    <div class="">
                        @if (Auth::guard('web')->user()->can('students.add'))
                            <a href="/students/create" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
                            <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add New</span>
                            </a>
                        @endif
                    </div>
                    <span id="user_id"  data-user-id="{{ Auth::user()->id }}"></span>
                    <div class="card-body table-responsive overflow-auto">
                        <!-- Table with stripped rows -->
                        <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'allstudents-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th width="20%">Student Info</th>
                                    <th width="20%">Class Info</th>
                                    <th width="25%">Payment Info</th>
                                    @if($status == 'Terminated')
                                        <th width="5%">Terminated On</th>
                                    @else
                                        <th width="5%">Admitted On</th>
                                    @endif
                                    <th width="30%">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <span id="student-id-{{ $loop->iteration }}" data-student-id="{{ $student->id }}"></span>
                                <span id="phone-{{ $loop->iteration }}" data-phone="{{ $student->phone }}"></span>
                                <tr>
                                    <td>
                                        <a @if (Auth::guard('web')->user()->can('students.edit')) href="/students/{{$student->id}}/edit" @endif>
                                            {{ $student->student_name }}
                                        </a>
                                        <br>
                                        <i class="ti ti-mail"></i>&nbsp; {{ $student->email }},<br>
                                        <i class="ti ti-clipboard"></i>&nbsp; {{ $student->student_id }},<br>
                                        <i class="ti ti-phone"></i>&nbsp; {{ $student->phone }}, 
                                        <a href="tel:{{ $student->phone }}" title="Call" onclick="saveStudentCallHistoryData({{ $loop->iteration }})" class="btn mb-1 btn-info btn-sm d-inline-flex align-items-center justify-content-center">
                                            <span class="callerIcon-{{ $loop->iteration }}" style="font-size: 8px; font-weight: bold;">
                                                <i class="ti ti-phone"> </i>&nbsp;Call
                                            </span>
                                        </a>
                                        <br>
                                        <i class="ti ti-user{{$student->gender == 'Female' ? '-heart' : '-circle'}}"></i>&nbsp; {{ $student->gender }}, <br>
                                        <i class="ti ti-layout-grid"></i>&nbsp; <span class="badge 
                                        @if($student->status == 1 || $student->status == 2) bg-success 
                                        @elseif($student->status == 0 ) bg-danger
                                        @else bg-warning
                                        @endif">
                                            @if($student->status == 1) Admitted
                                            @elseif($student->status == 2) Graduated
                                            @elseif($student->status == 3) On Hold
                                            @else Terminated
                                            @endif
                                        </span>
                                    </td> 
                                    <td><i class="ti ti-file-spreadsheet"></i>&nbsp;{{ $student->class_name }}, <br>
                                        <i class="ti ti-user-circle"></i>&nbsp; {{ $student->coordinatorName }}, <br>
                                        <i class="ti ti-clock-hour-4"></i>&nbsp;Started At : {{ $student->class_start_date}}, <br>
                                        <i class="ti ti-video"></i>&nbsp;Total Classes : {{$student->no_of_classes}} <br>
                                    </td>
                                    <td>Active Payments : {{ $student->active_payment == 1 ? 'Yes' : 'No' }}, <br>
                                        Payable Amount : {{ $student->payable_amount }},<br>
                                        Payment Status : {{ $student->payment_status }},<br>
                                        Due Date : {{ $student->due_date }}, <br>
                                        Due Installments : {{ $student->due_installments }} Month(s)<br>
                                        Due For Months : {{ $student->due_for_months }}<br>
                                    </td>
                                    @if($status == 'Terminated')
                                        <td>{{Carbon\Carbon::parse($student->terminated_on)->format('D d M, Y')}} At<br> {{Carbon\Carbon::parse($student->terminated_on)->addHours(6)->format('h:i A')}}</td>
                                    @else
                                        <td>{{ date('d M, Y', strtotime($student->admitted_on ))}} At<br> {{date('h:i A', strtotime($student->admitted_on." +6 hours" )) }}</td>
                                    @endif
                                    <td>
                                        @foreach($note_histories as $note_history)
                                            @if($student->id == $note_history->student_id)
                                                <span>{{ $note_history->note }}</span> - [<span style="font-size: 11px">{{ $note_history->stenographer->name }}<strong> on </strong>{{date('M d, Y', strtotime($note_history->created_at. ' + 6 hours'))}}<strong> at </strong>{{date('h:i A', strtotime($note_history->created_at. ' + 6 hours'))}}</span>]<br>
                                            @endif
                                        @endforeach
                                    </td>
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
    <script src="{{asset('assets/js/students/search-filter-1.0.2.js')}}"></script>

</x-dashboard.admin-layout>
