<x-admin-layout>
    <div class="pagetitle">
        <div class="row">
            <div class="col-xl-2"><h1 class="text-left">{{$new_session->sessionClass->name}}</h1></div>
            <div class="col-xl-10"><?php //dd($new_session); ?>
              <h1 class="text-right">
                  <a type="button" class="btn btn-outline-success" href="/project-assesment/create?class_id={{$new_session->class_id}}&project_id=1&from={{$from}}">Project Assesment</a>
                  <a type="button" class="btn btn-outline-success" href="/attendance/create/?class_id={{$new_session->class_id}}&date={{$new_session->session_date}}&from={{$from}}">Take Attendance</a>
                  {{-- <a type="button" class="btn btn-outline-primary" target="_blank" onclick="saveSession()"  href="https://lead.academy/meeting-host-sdk?live_id={{$new_meeting->id}}&username={{auth()->user()->name}}&redirecturl={{trim(route('end-session', ['id' => $new_session->id]) ,"https://")}}">Host Now &nbsp;<span class="bi bi-camera-video"></span></a> --}}
                  @if($new_session->status != null && $new_session->status != 'Completed')
                  <button class="btn btn-outline-danger" onclick="markSessionAsCompleted({{ $new_session->meeting_id }})">Mark As Completed</button>
                    @if($new_session->sessionClass->isZoomAutomated == 1)
                    {{-- <a type="button" target="_blank" class="btn btn-outline-primary" href="{{ (!empty($new_session->start_url) ? $new_session->start_url : '') }}" onclick="startClassStatusStore({{$new_session->id}})" >Start Class &nbsp;<span class="bi bi-camera-video"></span></a> --}}
                    <a type="button" class="btn btn-outline-primary" href="javascript:void(0)" id="startClassStatusStore" onclick="startClassStatusStore({{ $new_session->id }}, '{{ $new_session->meeting_id }}')" >Start Class &nbsp;<span class="bi bi-camera-video"></span></a>
                    @else
                    <a type="button" target="_blank" class="btn btn-outline-primary" href="{{auth()->user()->value_a}}">Launch Zoom &nbsp;<span class="bi bi-camera-video"></span></a>
                    @endif
                  @endif
              </h1>
            </div>
            <input type="hidden" id="class_id" value="{{$id}}">
            <input type="hidden" id="session_id" value="{{$new_session->session_id}}">
        </div>       
    </div>
    
    @if(!empty($new_session->recording_link))
    <h5 class="text-center font-weight-bold"> RECORDINGS </h5>
    <section>
      <div class="row">
        <div class="card col-md-4">
          <div class="card-body">
            <h5 class="card-title">{{$new_session->sessionClass->name}}</h5>
            <iframe src="{{$new_session->recording_link}}?h=fbaa1e04fb" width="100%" height="250" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div><!-- End Card with an image on bottom -->
      </div>
      </div>
    </section>
    @endif
    <section class="section">
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                <div class="d-flex justify-content-between my-3 mx-2">
                    <h5 class="">Today's Attendance</h5>
                </div>
                  <div class="card-body">
                      <!-- Table with stripped rows -->
                      <table class="table datatable">
                          <thead>
                              <tr>
                                  <th scope="col">Student</th>
                                  <th scope="col">Date</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Comments</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($attendances as $attendance)
                              <tr>
                                  <td>{{ $attendance->student->name }}</td>
                                  <td>{{ $attendance->date }}</td>
                                  <td>{{ $attendance->status == true ? 'Present' : 'Absent' }}</td>
                                  <td>{{ $attendance->comments }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                      <!-- End Table with stripped rows -->
                  </div>
              </div>
          </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between my-3 mx-2">
                        <h5 class="">Project Assessment</h5>
                    </div>
                    <div class="d-flex justify-content-between my-3 mx-2">
                        <h5 class="font-weight-bold">{{ $project_name }}</h5>
                    </div>
                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">Student Name</th>
                                <th scope="col">Learning Outcomes</th>
                                <th scope="col">Project Assesment</th>
                                <th scope="col">Status</th>
                                <th scope="col">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->student->name }}</td>
                                    <td>{{ $project->project->learning_outcomes }}</td>
                                    <td>{{ $project->project_assesment }}</td>
                                    <td>{{ $project->project_status }}</td>
                                    <td>{{ $project->comments }}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
          <div class="card">
              <div class="card-body">
                  <div class="d-flex justify-content-between my-3 mx-2">
                      <h5 class="">Homework</h5>
                  </div>
                  <div class="d-flex justify-content-between my-3 mx-2">
                      <h5 class="font-weight-bold">{{ $singleHomeworkProjectName }}</h5>
                  </div>
                  <!-- Table with stripped rows -->
                  <table class="table datatable">
                      <thead>
                          <tr>
                              <th scope="col">Student Name</th>
                              <th scope="col">Learning Outcomes</th>
                              <th scope="col">Project Assesment</th>
                              <th scope="col">Status</th>
                              <th scope="col">Comments</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($homeProjects as $project)
                              <tr>
                                  <td>{{ $project->student->name }}</td>
                                  <td>{{ $project->project->learning_outcomes }}</td>
                                  <td>{{ $project->project_assesment }}</td>
                                  <td>{{ $project->project_status }}</td>
                                  <td>{{ $project->comments }}</td>
                              </tr>
                              @endforeach
                      </tbody>
                  </table>
                  <!-- End Table with stripped rows -->
              </div>
          </div>
      </div>
  </div>
</section>

<script src="{{asset('assets/js/sessions/teacher-1.2.1.js')}}"></script>
</x-admin-layout>