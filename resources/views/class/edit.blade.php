<x-dashboard.admin-layout>
    <x-slot name='title'>Classes - Dreamers Academy</x-slot>
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            margin-top: -3px;
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
                          <h4 class="fw-semibold mb-8">Edit Class</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Update Class Form </li>
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
                <div class="card w-100 position-relative overflow-hidden mb-0">
                  <div class="card-body p-4">
                    <div class="nav nav-pills mb-3 rounded align-items-center flex-row">
                        <h5 class="card-title fw-semibold">Update Class Form </h5>
                        @if (Auth::guard('web')->user()->can('classes.list'))
                        <small class="ms-auto">
                          <a href="/class" class="btn btn-primary d-flex align-items-center px-3" id="add-notes">
                           <i class="ti ti-list me-0 me-md-1 fs-4"></i>
                            <span class="d-none d-md-block font-weight-medium fs-3">Classes</span>
                          </a>
                        </small>
                        @endif
                    </div>
                    
                    <form action="{{ route('class.update', $class->id) }}" method="POST">
                        @csrf @method('PUT')
                        
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="inputName5" class="form-label fw-semibold"><i class="text-danger"> * </i> Name</label>
                                <input type="text" name="name" value="{{ $class->name }}" class="form-control" id="inputName5">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="course_id" class="form-label fw-semibold"><i class="text-danger">* </i>Course</label>
                                <select id="course_id" name="course_id" class="form-select select2" onchange="courseWiseTrack()">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{$class->course_id == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="track_id" class="form-label fw-semibold"><i class="text-danger">*</i> Track</label>
                                <select id="track_id" name="track_id" class="form-select choices" onchange="trackWiseLevel()">
                                    <option value="">Select Track</option>
                                    @foreach($tracks as $track)
                                    <option value="{{ $track->id }}" {{ $class->track_id == $track->id ? 'selected' : '' }}>
                                        {{ $track->track_num }}
                                    </option>
                                    @endforeach
                                </select>
                              </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="level_id" class="form-label fw-semibold"><i class="text-danger">*</i> Level</label>
                            <select id="level_id" name="level_id" class="form-select choices">
                                <option value="">Select Level</option>
                                @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ $class->level_id == $level->id ? 'selected' : '' }}>
                                    {{ $level->level_num }}
                                </option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="teacher_id" class="form-label fw-semibold"><i class="text-danger">*</i> Teacher</label>
                            <select id="teacher_id" name="teacher_id" class="form-select choices" required>
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ $class->teacher_id == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="coordinator_id" class="form-label fw-semibold"><i class="text-danger">*</i> Coordinator</label>
                            <select id="coordinator_id" name="coordinator_id" class="form-select choices" required>
                                <option value="">Select Coordinator</option>
                                @foreach($coordinators as $coordinator)
                                <option value="{{ $coordinator->id }}" {{ $class->coordinator_id == $coordinator->id ? 'selected' : '' }}>
                                  {{ $coordinator->name }}
                                </option>
                                @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="teacher_id" class="form-label fw-semibold">Notifications</label><br>
                                <input type="radio" id="yes" name="notif_enable" value="1" {{ $class->notif_enable == 1 ? 'checked' : '' }}/>
                                <label for="yes" class="form-label">Yes</label>
                                <input type="radio" id="no" name="notif_enable" value="0" {{ $class->notif_enable == 0 ? 'checked' : '' }}/>
                                <label for="no" class="form-label">No</label>
                              </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="isZoomAutomated" class="form-label fw-semibold">Is Zoom Automated</label><br>
                                <input type="radio" id="zoomAutomatedYes" name="isZoomAutomated" value="1" {{ $class->isZoomAutomated == 1 ? 'checked' : '' }}/>
                                <label for="zoomAutomatedYes" class="form-label">Yes</label>
                                <input type="radio" id="zoomAutomatedNo" name="isZoomAutomated" value="0" {{ $class->isZoomAutomated == 0 ? 'checked' : '' }}/>
                                <label for="zoomAutomatedNo" class="form-label">No</label>
                              </div>
                        </div>
                      </div>

                        <div class="col-12">
                          <div class=" align-items-center justify-content-end mt-4 gap-3">
                            <a class="btn btn-light" href="/class">Back</a>
                            <button class="btn btn-danger float-end">
                                <a href="/inactive-class/{{$class->id}}" class="link-light">Inactive</a>
                            </button>
                            <button class="btn btn-primary float-end me-1">Save</button>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    <script>
      
    function courseWiseTrack(){
        var course_id = $("#course_id").val();
        
        $.ajax({
            url: "/course-wise-track",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            data: {
                course_id: course_id
            },
            beforeSend: function () {
                $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
            },
            success: function (r) {
                $("#track_id").html(r);
                $(".loader-populate").html("");
            },
            });
    }
      function trackWiseLevel(){
          var track_id = $("#track_id").val();
          $.ajax({
              url: "/track-wise-level",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              type: "POST",
              data: {
                  track_id: track_id
              },
              beforeSend: function () {
                $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
              },
              success: function (r) {
                  $("#level_id").html(r);
                  $(".loader-populate").html("");
              },
              });
      }
    </script>
</x-dashboard.admin-layout>