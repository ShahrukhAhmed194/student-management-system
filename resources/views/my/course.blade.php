<x-student-layout>

    <section class="section">
        <div class="pagetitle">
            <h4>{{ $student->class->course->name }}</h4>
        </div>
    </section>

    <section class="section dashboard">
        <div class="row">
            @foreach($class->class_schedules as $schedule)
            <div class="col-lg-3 col-lg-3">
                <div class="card info-card customers-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"></a>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Class Schedule</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar"></i>
                            </div>
                            <div class="ps-3">
                                <h5>{{ $schedule->day }} <br> {{ date('h:i a', strtotime($schedule->time)) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            @foreach($class->course->tracks as $track)
            @foreach($class->course->levels as $level)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="padding-bottom: 0px">
                        <h5 class="card-title" style="padding-bottom: 0px">Track: {{ $level->track->track_num }}, Level: {{ $level->level_num }}</h5>

                        <div class="accordion accordion-flush" id="accordionFlushExample" style="background-color: none">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                        <span class="badge bg-warning text-dark">In Progress</span>
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                                    <div class="accordion-body">
                                        <h5>Classes</h5>
                                        <div class="row">
                                            @foreach($attendances as $attendance)
                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: {{ $loop->index +1 }}</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">{{ $attendance == true ? 'Complete' : 'Absent' }}</strong>
                                                        </div>
                                                        <!-- <div style="padding-top: 5px">
                                                            Project: <strong class="text-success">Good</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-success">9/10</strong>
                                                        </div> -->
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach


                                            <!-- <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 5</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">Complete</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-success">Excellent</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-success">7/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>

                                        <h5>Projects</h5>
                                        <div class="row">
                                            @foreach($projects as $project)
                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Project No: {{ $loop->index + 1}}</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">{{ $project->project_status }}</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project Assessment: <strong class="text-secondary">{{ $project->project_assesment }}</strong>
                                                        </div>
                                                        <!-- <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-warning">6/10</strong>
                                                        </div> -->
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm" disabled="">View Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        <h5>Quizs</h5>
                                        <div class="row">
                                            @foreach($quizs as $quiz)
                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Quiz No: {{ $loop->index + 1}}</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">{{ $quiz->quiz_status }}</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz Mark: <strong class="text-secondary">{{ $quiz->mark }}</strong>
                                                        </div>
                                                        <!-- <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-warning">6/10</strong>
                                                        </div> -->
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm" disabled="">View Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endforeach
        </div>

        <!-- <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="padding-bottom: 0px">
                        <h5 class="card-title" style="padding-bottom: 0px">Track: 1, Level: 2</h5>

                        <div class="accordion accordion-flush" id="accordionFlush2Example" style="background-color: none">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-heading2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
                                        <span class="badge bg-success">Completed</span>
                                    </button>
                                </h2>
                                <div id="flush-collapse2" class="accordion-collapse collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordionFlush2Example" style="">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 8</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">Complete</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-success">Excellent</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-success">10/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 7</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">Complete</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-success">Good</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-success">9/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 6</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">Complete</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-success">Good</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-success">9/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 5</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">Complete</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-success">Excellent</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-success">7/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 4</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-danger">Absent</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-danger">Didn't Start</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-danger">0/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm" disabled="">View Details</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 3</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">Complete</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-warning">Average</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-warning">6/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 2</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">Complete</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-danger">Below Average</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-danger">4/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Class No: 1</h5>
                                                        <p>
                                                        </p>
                                                        <div>
                                                            Status: <strong class="text-success">Complete</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Project: <strong class="text-warning">Average</strong>
                                                        </div>
                                                        <div style="padding-top: 5px">
                                                            Quiz: <strong class="text-warning">6/10</strong>
                                                        </div>
                                                        <p></p>
                                                        <button type="button" class="btn btn-primary btn-sm">View Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </section>
</x-student-layout>