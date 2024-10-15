<?php 
    use App\Models\ClassSession;   
    $dayOfToday = date('l');
?>
<x-parent-layout>

    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div>
    <section class="section dashboard">
        <div class="row pb-3">
            <?php 
            foreach ($students as $key => $student){
                $todays_session = ClassSession::where('class_id', $student->class_id)
                                    ->where('session_date', date('Y-m-d'))
                                    ->first();
                ?>
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="card h-100">
                        <div class="card-body p-0">
                            <img src="{{asset('assets/img/profile.png')}}" class="card-img-top p-2" alt="...">
                            <h5 class="card-title pl-3">{{ $student->user->name }} </h5>
                            <p class="pl-3">
                                {{ $student->class->name }} 
                                <span class="badge badge-{{(@$todays_session->status == 'completed' ? 'success' : 'primary')}}">{{ empty($todays_session) ? '' : $todays_session->status}}</span>
                            </p>
                            <p class="pl-3"> <strong>{{ $student->day }} At {{date('h:i a', strtotime($student->time)) }}</strong> </p>
                        </div>
                        <div class="p-2 pb-2 pr-2">
                            <?php
                                if($todays_session){
                                    if($student->class->isZoomAutomated == 1){
                                            if($todays_session->class_status == 1 && $todays_session->status == 'Active'){
                                            ?>
                                                <a href="{{ !empty($todays_session->join_url) ? $todays_session->join_url : '' }}" class="btn btn-sm btn-outline-success float-end" onclick="joinLiveClassParticipant({{$student->studentId}}, {{$todays_session->id}})" target="_new">
                                                    Join Class 
                                                </a>
                                    <?php
                                            }
                                    }
                                }
                            ?>
                            <form action="{{route('show-parent-sessions')}}" method="POST">
                                @csrf
                                <input type="hidden" name="class_id" value="{{ $student->class_id }}" >
                                <input type="hidden" name="student_id" value="{{ $student->user_id }}">
                                <button class="btn btn-sm btn-outline-primary">Class Report</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div> 
        @foreach($students as $student)
            @if($student->due_installments > 0)
                <div class="alert alert-danger text-center">
                    <b>{{$student->user->name}} Has {{$student->due_installments}} Month(s) Payment Due!</b>
                </div>
            @endif
        @endforeach 
    </section>
    {{-- <div class="row">
        <div class="pagetitle" style="padding-bottom: 10px">
            <h1>Today's Class</h1>
        </div>
       
        <?php 
        // dd($class_schedules);
        // $dayOfToday = Carbon::now()->addHours(6)->format('l');
        // foreach($class_schedules as $schedule){
        // $todays_session = ClassSession::where('class_id', $schedule->class_id)
        //                             ->where('session_date', date('Y-m-d'))
        //                             ->first();
        ?>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/my-session-list/{{ $student->class->id }}">
                                {{ $student->class->name }}
                            </a>
                        </h5>
                        <p>
                            {{ $student->class->name }} 
                            <span class="badge badge-success">{{ empty($todays_session) ? '' : $todays_session->status}}</span>
                        </p>
                        <p>
                            Track#{{ $student->class->track->track_num }}, Level#{{ $student->class->level->level_num }} <br>
                        </p>
                        <a href="{{ !empty($todays_session->liveSession->join_url) ? $todays_session->liveSession->join_url : '' }}" class="btn btn-success {{$todays_session->status == 'Completed' ? 'd-none' : ''}}"  >Join Class</a>
                    </div>
                    <input type="hidden" id="class_id" value="{{ $schedule->class->id }}">
                </div>
            </div>
        <?php //} ?>
    </div> --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-body">
                        <div class=" m-3">
                            <h5 class="text-center font-weight-bold text-danger">Important Notice</h5>
                            <p><h5 class="text-danger">Due to technical issues, currently online payment from app has been Disabled. Please make your payment through Bkash, Nagad or Bank transfer.</h5><br>
                                <b>Our payment procedures:</b><br><br>
                                You can deposit your fees by,<br>
                                1. <b>bKash Merchant Account:</b> +8801301528308 <br>
                                2. <b>Nagad:</b> 01301507842<br>
                                (Please mention your child's full name in the <b>REFERENCE</b> before you transfer the fees). <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </section>
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">Last Five Payments</h5>
                            {{-- <a href="/payment/fee" type="button" class="btn btn-primary float-right">Pay Fee</a> --}}
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Child</th>
                                    <th scope="col">Fee</th>
                                    <th scope="col">For The Month(s)</th>
                                    <th scope="col">Note</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($payments) > 0)
                                @foreach ($payments as $payment)
                                <tr>
                                    <td>{{$payment->date}}</td>
                                    <td>{{$payment->name}}</td>
                                    <td>৳{{$payment->fees}}</td>
                                    <?php
                                    for($i=0; $i < strlen($payment->for_month); $i++){
                                        $payment->for_month = trim($payment->for_month,'[]');
                                        $payment->for_month = str_replace('"','',$payment->for_month);
                                    }?>
                                    <td>{{$payment->for_month}}</td>
                                    <td>{{$payment->notes}}</td>
                                    <td>{{$payment->payment_status}}</td>
                                    <td><a href="/payment/{{$payment->id}}/invoice">view</a></td>
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
    </section>
    {{-- <section class="section dashboard">
        <div class="row">
            @foreach($students as $student)
                @if ($student->class->count() > 0)
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="card-title">{{ $student->user->name }}</h4>
                            <p>
                                <h5>{{$student->class->name}} : </h5>
                                @if($student->class->class_schedules->count() > 0)
                                    @foreach($student->class->class_schedules as $schedule)
                                    <h5>{{$schedule->day}} At {{date('h:i a', strtotime($schedule->time)) }}</h5>
                                    @endforeach
                                @endif
                                Track #{{ $student->class->track->track_num }}, &nbsp;Level #{{ $student->class->level->level_num }}
                                <h4 class="card-title">Meeting Details : </h4>
                                <a target="_blank" href="{{$student->class->teacher->value_a}}"> {{$student->class->teacher->value_a}}</a><br>
                                {{ $student->class->teacher->class_login_details }}<br>
                                
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div> 
    </section> --}}

    <script>
        function joinLiveClassParticipant(studentId, classSessionId){
        
            $.ajax({
                url: "/class-session-participant-store",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data: {
                    student_id: studentId,
                    class_session_id: classSessionId,
                },
                beforeSend: function () {
                    $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
                },
                success: function (r) {
                    $(".loader-populate").html("");
                },
                });
        }
    </script>
</x-parent-layout>