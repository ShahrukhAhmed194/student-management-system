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
                          <h4 class="fw-semibold mb-8">New Class</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">New Class Form</li>
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
                        <h5 class="card-title fw-semibold">New Class Form</h5>
                        @if (Auth::guard('web')->user()->can('classes.list'))
                        <small class="ms-auto">
                          <a href="/class" class="btn btn-primary d-flex align-items-center px-3" id="add-notes">
                           <i class="ti ti-list me-0 me-md-1 fs-4"></i>
                            <span class="d-none d-md-block font-weight-medium fs-3">Classes</span>
                          </a>
                        </small>
                        @endif
                    </div>
                    
                    <form action="{{ route('class.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" id="status" value="1">
                        
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="inputName5" class="form-label fw-semibold"><i class="text-danger"> * </i> Name</label>
                                <input type="text" name="name" class="form-control" id="inputName5">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="course_id" class="form-label fw-semibold"><i class="text-danger">* </i>Course</label>
                                <select id="course_id" name="course_id" class="form-select select2" onchange="courseWiseTrack()">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
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
                                    
                                </select>
                              </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="level_id" class="form-label fw-semibold"><i class="text-danger">*</i> Level</label>
                            <select id="level_id" name="level_id" class="form-select choices">
                                <option value="">Select Level</option>
                                
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
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="coordinator_id" class="form-label fw-semibold"><i class="text-danger">*</i> Coordinator</label>
                            <select id="coordinator_id" name="coordinator_id" class="form-select choices">
                                <option value="">Select Coordinator</option>
                                @foreach($coordinators as $coordinator)
                                <option value="{{ $coordinator->id }}">{{ $coordinator->name }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                        <div class="col-12">
                          <div class=" align-items-center justify-content-end mt-4 gap-3">
                            <a class="btn btn-light" href="/class">Back</a>
                            <button class="btn btn-primary float-end">Save</button>
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