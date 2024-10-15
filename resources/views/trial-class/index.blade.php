<x-dashboard.admin-layout>
    <x-slot name='title'>Trial Class - Dreamers Academy</x-slot>
    <style>
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--multiple {
            line-height: 22px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">All Trial Classes</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Trial Class</li>
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
                                    <form action="/trial-class-search" method="get" >
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="label fw-semibold" for="studentName" >Student Name</label>
                                                        <input type="text" name="studentName" id="studentName" class="form-control" value="{{ !empty($parametersData['studentName']) ? $parametersData['studentName'] : '' }}">
                                                        @error('from_date')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="track" >Track</label>
                                                        <select id="track" name="track" class="form-select ">
                                                        <option value="">
                                                            Select Track
                                                        </option>
                
                                                        <option value="1" {{ ($parametersData['track'] == '1') ? 'selected' : ''}}>
                                                            Track 1
                                                        </option>
                                                        
                                                        <option value="2"  {{ ($parametersData['track'] == '2') ? 'selected' : ''}}>
                                                            Track 2
                                                        </option>
                
                                                        <option value="3"  {{ ($parametersData['track'] == '3') ? 'selected' : ''}}>
                                                            Track 3
                                                        </option>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputFromDate" >Scheduled From</label>
                                                        <input type="date" name="from_date" id="from_date" class="form-control" value="{{ !empty($parametersData['from_date']) ? $parametersData['from_date'] : '' }}">
                                                        @error('from_date')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputToDate" >Scheduled To</label>
                                                        <input type="date" name="to_date" id="to_date" class="form-control" value="{{ !empty($parametersData['to_date']) ? $parametersData['to_date'] : '' }}">
                                                        @error('to_date')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="time" class="">Scheduled Time</label>
                                                <input type="time" name="time" id="time" class="form-control" value="{{ !empty($parametersData['time']) ? $parametersData['time'] : '' }}">
                                                @error('from_date')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="row mt-2">
                                                    <div class="col-md-4">
                                                        <label for="trial_id" >Trial Class ID</label>
                                                        <input type="text" name="trial_id" id="trial_id" class="form-control" value="{{ !empty($parametersData['trial_id']) ? $parametersData['trial_id'] : '' }}">
                                                        @error('trial_id')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="inputAppliedFromDate" >Applied From</label>
                                                        <input type="date" name="applied_from_date" id="applied_from_date" class="form-control" value="{{ !empty($parametersData['applied_from_date']) ? $parametersData['applied_from_date'] : '' }}">
                                                        @error('applied_from_date')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="inputAppliedToDate" >Applied To</label>
                                                        <input type="date" name="applied_to_date" id="applied_to_date" class="form-control" value="{{ !empty($parametersData['applied_to_date']) ? $parametersData['applied_to_date'] : '' }}">
                                                        @error('applied_to_date')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mt-2">
                                                <label for="country" class="">Country</label>
                                                <select id="country" name="country" class="form-select ">
                                                    <option value="">
                                                        Select country
                                                    </option>
                
                                                    <option {{ ($parametersData['country'] == 'Bangladesh') ? 'selected' : ''}}>
                                                        Bangladesh
                                                    </option>
                                                    
                                                    <option {{ ($parametersData['country'] == 'India') ? 'selected' : ''}}>
                                                        India
                                                    </option>
                
                                                    <option {{ ($parametersData['country'] == 'United Kingdom') ? 'selected' : ''}}>
                                                        United Kingdom
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label for="status" class="col-md-4">Status</label>
                                                <select id="status" name="status[]" class="form-control select2" multiple="multiple" data-placeholder="Select status">
                                                    <option value="Absent" {{ ($parametersData['status'] == 'Absent') ? 'selected' : ''}}>Absent</option>
                                                    <option value="Admitted" {{ ($parametersData['status'] == 'Admitted') ? 'selected' : ''}}>Admitted</option>
                                                    <option value="Attended" {{ ($parametersData['status'] == 'Attended') ? 'selected' : ''}}>Attended</option>
                                                    <option value="Payment Pending" {{ ($parametersData['status'] == 'Payment Pending') ? 'selected' : ''}}>Payment Pending</option>
                                                    <option value="Refused Admission" {{ ($parametersData['status'] == 'Refused Admission') ? 'selected' : ''}}>Refused Admission</option>
                                                    <option value="Registered" {{ ($parametersData['status'] == 'Registered') ? 'selected' : ''}}>Registered</option>
                                                    <option value="Rescheduled" {{ ($parametersData['status'] == 'Rescheduled') ? 'selected' : ''}}>Rescheduled</option>
                                                    <option value="Will Admit Later" {{ ($parametersData['status'] == 'Will Admit Later') ? 'selected' : ''}}>Will Admit Later</option>
                                                    <option value="Will Attend" {{ ($parametersData['status'] == 'Will Attend') ? 'selected' : ''}}>Will Attend</option>
                                                    <option value="Not Interested" {{ ($parametersData['status'] == 'Not Interested') ? 'selected' : ''}}>Not Interested</option>
                                                    <option value="Decision Pending" {{ ($parametersData['status'] == 'Decision Pending') ? 'selected' : ''}}>Decision Pending</option>
                                                    <option value="Not Reachable" {{ ($parametersData['status'] == 'Not Reachable') ? 'selected' : ''}}>Not Reachable</option>
                                                    <option value="Wants to Reschedule" {{ ($parametersData['status'] == 'Wants to Reschedule') ? 'selected' : ''}}>Wants to Reschedule</option>
                                                    <option value="Joined" {{ ($parametersData['status'] == 'Joined') ? 'selected' : ''}}>Joined</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 mt-2">
                                                <label for="sales_user_id" class="">Assigned Sales Person</label>
                                                <select id="sales_user_id" name="sales_user_id" class="form-select ">
                                                    <option value="">
                                                        Select Sales Person
                                                    </option>
                                                    <?php foreach($getSalesUsers as $salesUser){ ?>
                                                        <option  value="{{ $salesUser->user_id }}" {{ ($salesUser->user_id == $parametersData['sales_user_id']) ? 'selected' : ''}}>
                                                            {{ (!empty($salesUser->user->name) ? $salesUser->user->name : '') }}
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mt-2">
                                                <label for="coordinator_id" class="">Coordinator</label>
                                                <select id="coordinator_id" name="coordinator_id" class="form-select select2">
                                                    <option value="">
                                                        Coordinator
                                                    </option>
                                                    @foreach($customerSupportExecutives as $customerSupportExecutive)
                                                        <option  value="{{ $customerSupportExecutive->id }}" {{ ($customerSupportExecutive->id == $parametersData['coordinator_id']) ? 'selected' : ''}}>
                                                            {{ $customerSupportExecutive->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label for="email" >Student Email</label>
                                                <input type="text" name="email" id="email" class="form-control" value="{{ !empty($parametersData['email']) ? $parametersData['email'] : '' }}">
                                                @error('email')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label for="phone" >Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control" value="{{ !empty($parametersData['phone']) ? $parametersData['phone'] : '' }}">
                                                @error('phone')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 mt-2">
                                                <label for="hasDevice" >Has Device</label>
                                                <select id="hasDevice" name="hasDevice" class="form-select ">
                                                    <option value=""> Select Device </option>
                                                    <option value="1" {{ ($parametersData['hasDevice'] == 1) ? 'selected' : ''}}> Yes </option>
                                                    <option value="0" {{ ($parametersData['hasDevice'] == '0') ? 'selected' : ''}}> No </option>
                                                </select>
                                            </div>
                                        </div>
                                        @php 
                                        $allStatus = $parametersData['status'];
                
                                        @endphp
                                        <div class="row">
                                            <div class="col-9"></div>
                                            <div class="col-3 ">
                                                <button type="submit" class="btn btn-sm btn-outline-primary mt-2 float-end" style="width: 8rem" onclick="getFilter()" > SEARCH </button>
                                            </div>
                                        </div>
                                    </form>
                                @if ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-block text-center ml-auto mr-auto mt-auto">
                                        <button type="button" class="close" data-dismiss="alert">×</button>	
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif
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
                        <span id="user_id"  data-user-id="{{ Auth::user()->id }}"></span>
                        <table
                      id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'trialclass-datatable' : 'basic-datatable' }}"
                      class="table border table-striped table-bordered display table-responsive"
                    >
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="25%">Class Details</th>
                                    <th width="10%">Scheduled</th>
                                    <th width="10%">Applied</th>
                                    <th width="25%">Note</th>
                                    <th width="25%">Trial Feedback</th>
                                </tr>
                            </thead>
                            <tbody>
                            <br>
                            <?php
                            $paramUrl = url()->full();
                            $paramUrl = urlencode($paramUrl);
                            ?>
                                @foreach($trial_classes as $trial_class)
                                <span id="trial-class-id-{{ $loop->iteration }}" data-trial-class-id="{{ $trial_class->id }}"></span>
                                <span id="phone-{{ $loop->iteration }}" data-phone="{{ $trial_class->phone }}"></span>
                                <tr>
                                    <td>{{ $trial_class->id }}</td>
                                    <td>
                                        @if (Auth::guard('web')->user()->can('trial_class.edit'))
                                        <a href="/trial-class/{{$trial_class->id}}/edit?backlink={{ $paramUrl }}">@endif<strong>{{ $trial_class->student_name }}</strong></a>&nbsp;
                                        <span class="badge 
                                            @if($trial_class->status == 'Registered' || $trial_class->status == 'Will Admit Later') 
                                            bg-primary
                                            @elseif($trial_class->status == 'Admitted' || $trial_class->status == 'Will Attend' || $trial_class->status == 'Payment Pending')
                                            bg-success 
                                            @elseif($trial_class->status == 'Rescheduled' || $trial_class->status == 'Attended' || $trial_class->status == 'Joined')
                                            bg-warning
                                            @else
                                                bg-danger
                                            @endif
                                            ">
                                            {{ $trial_class->status }}
                                        </span><br>
                                        <strong>From:</strong> {{ $trial_class->country }} <br>
                                        <strong>Contact:</strong> {{ $trial_class->phone }} 
                                        <a href="tel:{{ $trial_class->phone }}" title="Call" onclick="saveTrialClassCallHistoryData({{ $loop->iteration }})" class="btn mb-1 btn-info btn-sm d-inline-flex align-items-center justify-content-center">
                                            <span class="callerIcon-{{ $loop->iteration }}" style="font-size: 8px; font-weight: bold;">
                                                <i class="ti ti-phone"> </i>&nbsp;Call
                                            </span>
                                        </a>
                                        <br>
                                        <strong>Email:</strong> {{ $trial_class->email }} <br>
                                        <strong>Instructor:</strong> {{ (!empty($trial_class->teacher_name) ? $trial_class->teacher_name : '') }} 
                                        <strong>(@if($trial_class->age == 7 || $trial_class->age == 8)
                                            Track-1
                                            @elseif($trial_class->age == 9 || $trial_class->age == 10)
                                            Track-2
                                            @else
                                            Track-3
                                            @endif)
                                        </strong><br>
                                        <strong>Has Device: </strong> {{ (($trial_class->hasDevice == 1) ? 'Yes' : 'No') }}<br>
                                        <strong>Assigned Sale Person: </strong> {{ (!empty($trial_class->sales_user) ? $trial_class->sales_user : '') }}<br>
                                        <strong>Coordinator: </strong> {{ (!empty($trial_class->coordinator) ? $trial_class->coordinator : '') }}<br>
                                    </td>
                                    <td>{{ date('d M, Y', strtotime($trial_class->date)) }} <strong>at</strong> {{ date('h:i A', strtotime($trial_class->time)) }}</td>
                                    <td>{{ date('d M, Y', strtotime($trial_class->createdAt))}} <strong>at</strong> {{date('h:i A', strtotime($trial_class->createdAt))}}</td>
                                    <td>
                                    @foreach($note_histories as $note_history)
                                        @if($trial_class->id == $note_history->trial_class_id)
                                        <span>{{ $note_history->note }}</span> - [<span style="font-size: 11px">{{ $note_history->stenographer->name }}<strong> on </strong>{{ $note_history->created_at }}</span>]<br>
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $trial_class->feed_back }}</td>
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

    <script>
        $(document).ready(function() {
            
        $("#trialclass-datatable").DataTable({
        dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
        scrollX:true,
        buttons: ["excel", "pdf", "print"],
        buttons: [
            {
                extend: "excel",
                title: "Trial-class",
                text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                titleAttr: 'Trial class Excel File',
                footer: true,
                messageTop: 'Trial class Report',
                className: "btn-sm btn-sm btn-success",
            },
            {
                extend: "print",
                title: "Trial class",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                titleAttr: 'Trial class Print File',
                footer: true,
                messageTop: 'Trial class Report',
                className: "btn-sm btn-sm btn-primary",
            },
            {
                extend: "pdf",
                title: "Trial class",
                    text: '<i class="ti ti-file-text"></i> PDF',
                titleAttr: 'Trial class PDF File',
                footer: true,
                messageTop: 'Trial class Report',
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

    function getFilter(){
        var studentName = $("#studentName").val();
        var track = $("#track").val();
        var time = $("#time").val();
        var trial_id = $("#trial_id").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();
        var applied_from_date = $("#applied_from_date").val();
        var applied_to_date = $("#applied_to_date").val();
        var country = $("#country").val();
        var status = $("#status").val();
        var sales_user_id = $("#sales_user_id").val();
        var coordinator_id = $("#coordinator_id").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var hasDevice = $("#hasDevice").val();

        if(studentName == ''){
            $('#studentName').attr("disabled", true);
        }
        if(track == ''){
            $('#track').attr("disabled", true);
        }
        if(trial_id == ''){
            $('#trial_id').attr("disabled", true);
        }
        if(time == ''){
            $('#time').attr("disabled", true);
        }
        if(from_date == ''){
            $('#from_date').attr("disabled", true);
        }
        if(to_date == ''){
            $('#to_date').attr("disabled", true);
        }
        if(applied_from_date == ''){
            $('#applied_from_date').attr("disabled", true);
        }
        if(applied_to_date == ''){
            $('#applied_to_date').attr("disabled", true);
        }
        if(country == ''){
            $('#country').attr("disabled", true);
        }
        if(status == ''){
            $('#status').attr("disabled", true);
        }
        if(sales_user_id == ''){
            $('#sales_user_id').attr("disabled", true);
        }
        if(coordinator_id == ''){
            $('#coordinator_id').attr("disabled", true);
        }
        if(email == ''){
            $('#email').attr("disabled", true);
        }
        if(phone == ''){
            $('#phone').attr("disabled", true);
        }
        if(hasDevice == ''){
            $('#hasDevice').attr("disabled", true);
        }
    }

    function saveTrialClassCallHistoryData(sl){
    var fd = new FormData();
    var user_id = $("#user_id").attr('data-user-id');
    var trial_class_id = $("#trial-class-id-"+sl).attr('data-trial-class-id');
    var phone = $("#phone-"+sl).attr('data-phone');
    

    fd.append("user_id", user_id);
    fd.append("trial_class_id", trial_class_id);
    fd.append("phone", phone);

    $.ajax({
        url: "save-trial-class-call-history",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data: fd,
        enctype: "multipart/form-data",
        processData: false,
        contentType: false,
        beforeSend:function(){
            var loaderImg = "/assets/img/ajax-loader.gif";
            $(".callerIcon-"+sl).html('<img src="'+ loaderImg +'" /> &nbsp; Calling ...');  
        },
        success: function (response) {
            if(response == 1){
                $(".callerIcon-"+sl).html("<i class='ti ti-phone'> </i>&nbsp;Call")
            }
        },
        error: function (data){
            console.log('fail');
        }
    });
        
    }
    </script>
</x-dashboard.admin-layout>