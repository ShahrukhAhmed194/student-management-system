<x-dashboard.teacher-layout>
    <x-slot name='title'>Dashboard - Dreamers Academy</x-slot>
    <section class="body-wrapper">
        <div class="container-fluid" style="padding-top: 150px !important;">
            <div class="note-has-grid">
                <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="
                                nav-link
                                note-link
                                d-flex
                                align-items-center
                                justify-content-center
                                px-3 px-md-3
                                me-0 me-md-2 text-body-color
                            " id="note-business">
                        <i class="ti ti-briefcase fill-white me-0 me-md-1"></i>
                        <span class="d-none d-md-block font-weight-medium">Today's Classes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="
                                nav-link
                                note-link
                                d-flex
                                align-items-center
                                justify-content-center
                                px-3 px-md-3
                                me-0 me-md-2 text-body-color
                            " id="note-social">
                        <i class="ti ti-share fill-white me-0 me-md-1"></i>
                        <span class="d-none d-md-block font-weight-medium">Trial Classes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void(0)" class="
                                nav-link
                                note-link
                                d-flex
                                align-items-center
                                justify-content-center
                                px-3 px-md-3
                                me-0 me-md-2 text-body-color
                            " id="note-important">
                        <i class="ti ti-star fill-white me-0 me-md-1"></i>
                        <span class="d-none d-md-block font-weight-medium">Regular Classes</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="note-full-container" class="note-has-grid row">
                        @foreach($todays_schedules as $key => $schedule)
                            <div class="col-md-3 single-note-item note-business">
                                <div class="card card-body">
                                    <span class="side-stick"></span>
                                    <h6 class="note-title text-truncate w-75 mb-0" data-noteHeading="Go for lunch"> {{$schedule->day}} At {{ date('h:i a', strtotime($schedule->time)) }} </h6>
                                    <p class="note-date fs-2">{{ $schedule->class->name }}</p>
                                    <div class="note-content">
                                        <p class="note-inner-content" data-noteContent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> 
                                            Track#{{ $schedule->class->track->track_num }}, Level#{{ $schedule->class->level->level_num }}<br>
                                            @if($status != [] && !empty($status[$key]))
                                                <span class="badge mt-3 {{$status[$key] == 'Active' ? 'bg-warning' : 'bg-success'}}">{{$status[$key]}}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a class="link text-success ms-2" href="{{route('session-teacher',['id' => $schedule->class->id])}}">
                                            Enter Session
                                        </a>
                                    <div class="ms-auto">
                                        <div class="category-selector btn-group">
                                            <a class="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                                                <div class="category">
                                                    <i class="ti ti-dots-vertical fs-5" id="count_button_{{$schedule->id}}" onClick="getTodaysClassStudents({{$schedule->id}}, {{$schedule->class->id}})"></i>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right category-menu">
                                                <span class="note-business badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center" id="today_students_{{$schedule->id}}"></span>    
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($trial_classes->count() > 0)
                            @foreach($trial_classes as $trial_class)
                                <div class="col-md-3 single-note-item  note-social">
                                    <div class="card card-body">
                                        <span class="side-stick"></span>
                                        <h6 class="note-title text-truncate w-75 mb-0" data-noteHeading="Meeting with Mr.Jojo">{{ date('d M, Y', strtotime($trial_class->date)) }} <br></h6>
                                        <p class="note-date fs-2">At {{date('h:i A', strtotime($trial_class->time))}}</p>
                                        <div class="note-content">
                                            <p class="note-inner-content" data-noteContent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis.">
                                                <strong>Date :</strong> {{ date('d M, Y', strtotime($trial_class->date)) }} <br>
                                                <strong>Time :</strong> {{ date('h:i A', strtotime($trial_class->time)) }}<br>
                                                <strong>Students :</strong>{{DB::table('trial_classes')->where('trial_class_id',$trial_class->id)->where('status','!=', 'Invalid')->where('status','!=', 'Wants to Reschedule')->count()}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif  

                        @foreach($schedules as $single)
                            @foreach($single as $schedule)
                                <div class="col-md-3 single-note-item note-important">
                                    <div class="card card-body">
                                        <span class="side-stick"></span>
                                        <h6 class="note-title text-truncate w-75 mb-0" data-noteHeading="Give Review for design">{{$schedule->day}} At {{ date('h:i a', strtotime($schedule->time)) }}</h6>
                                        <p class="note-date fs-2">{{ $schedule->class->name }}</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="note-content">
                                                    <p class="note-inner-content" data-noteContent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> 
                                                        Track#{{ $schedule->class->track->track_num }}, Level#{{ $schedule->class->level->level_num }}<br>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-auto mt-3">
                                                        <div class="category-selector btn-group">
                                                            <a class="nav-link category-dropdown label-group " data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                                                            <div class="category">
                                                                <i class="ti ti-dots-vertical fs-5" id="count_button_{{$schedule->id}}" onClick="getRegularClassStudents({{$schedule->id}}, {{$schedule->class->id}});"></i>
                                                            </div>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right category-menu">
                                                                <span class="note-business badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center" id="students_{{$schedule->id}}"></span>
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
                </div>
            </div>
        </div>
    </section>
    
    <script src="{{asset('assets/js/dashboards/teacher-1.2.0.js')}}"></script>
    <script src="{{asset('assets/modernize/js/apps/notes.js')}}"></script>
</x-dashboard.teacher-layout>
