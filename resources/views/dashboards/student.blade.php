<x-student-layout>
    <div class="pagetitle" style="padding-bottom: 10px">
        {{-- <h1>Home</h1> --}}
    </div>
    <section class="section dashboard">
        {{-- <div class="row">
            <div class="col-lg-3 col-lg-3">
                <div class="card info-card customers-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Pending Projects</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6><a href="#">{{ $projects->count() }}</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-lg-3">
                <div class="card info-card customers-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Pending Quizzes</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6><a href="#">{{ $quizs->count() }}</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats statistic-box mb-4">
                            <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
                                <div class="card-icon d-flex align-items-center justify-content-center">
                                    <img src="{{ URL::to('/assets/img/coin-1.png') }}" class="mt-3 img-fluid">
                                </div>
                                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted ">
                                    Total Points </p>
                                <h3 class="card-title fs-21 font-weight-bold text-muted ">{{ $totalPoint }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
        <div class="row">
            <div class="pagetitle" style="padding-bottom: 10px">
                <h1>My Class</h1>
            </div>
            @foreach($class_schedules as $schedule)
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a @if(auth('web')->user()->can('codingforkids.list')) href="/my-session-list/{{ $student->class->id }}" @endif>{{ $student->class->name }}</a>
                        </h5>
                        <p>Class Day: <strong>{{ $schedule->day }}</strong> <span class="badge badge-success">{{ $todays_session_status}}</span></p>
                        <p>
                            Track#{{ $student->class->track->track_num }}, Level#{{ $student->class->level->level_num }}<br>
                            <!-- Class No: 7 -->
                        </p>
                        <button class="btn btn-outline-success {{$todays_session_status == 'Completed' ? 'd-none' : ''}}" onclick="checkIfSessionStarted()" >See Class Details</button>
                        <?php
                            if($todays_session){
                                if($student->class->isZoomAutomated == 1){
                                        if($todays_session->class_status == 1 && $todays_session->status == 'Active'){
                                        ?>
                                            <a href="{{ !empty($todays_session->join_url) ? $todays_session->join_url : '' }}" class="btn btn-sm btn-outline-success float-end" onclick="joinLiveClassParticipant({{ $student->id }}, {{ $todays_session->id }})" target="_new">
                                                Join Class 
                                            </a>
                                <?php 
                                        }
                                }
                            }
                        ?>
                    </div>
                    <input type="hidden" id="class_id" value="{{$schedule->class->id}}">
                </div>
            </div>
            @endforeach
        </div>
    </section>
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
                    console.log(r);
                    $(".loader-populate").html("");
                },
                });
        }
    </script>
    <script src="{{asset('assets/js/dashboards/student-1.0.1.js')}}"></script>
</x-student-layout>