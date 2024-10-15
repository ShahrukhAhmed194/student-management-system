<x-dashboard.admin-layout>
    <x-slot name='title'>Projects - Dreamers Academy</x-slot>
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
                          <h4 class="fw-semibold mb-8">New Project</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">New Project Form</li>
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
                        <h5 class="card-title fw-semibold">New Project Form</h5>
                        @if (Auth::guard('web')->user()->can('project.list'))
                        <small class="ms-auto">
                          <a href="/project" class="btn btn-primary d-flex align-items-center px-3" id="add-notes">
                           <i class="ti ti-list me-0 me-md-1 fs-4"></i>
                            <span class="d-none d-md-block font-weight-medium fs-3">Project List</span>
                          </a>
                        </small>
                        @endif
                    </div>
                    
                    <form action="{{ route('project.store') }}" method="POST">
                        @csrf
                        
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold"><i class="text-danger"> * </i> Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="learning_outcomes" class="form-label fw-semibold"><i class="text-danger">* </i>Learning Outcomes</label>
                                <textarea class="form-control" name="learning_outcomes" id="learning_outcomes" cols="30" rows="2" required></textarea>
                              </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="link_teacher" class="form-label fw-semibold"><i class="text-danger">* </i> Link Teacher</label>
                                <input type="text" name="link_teacher" class="form-control" id="link_teacher" required>
                              </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="link_student_before" class="form-label fw-semibold"><i class="text-danger">* </i> Link Student Before</label>
                            <input type="text" name="link_student_before" class="form-control" id="link_student_before" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="link_student_after" class="form-label fw-semibold"><i class="text-danger">* </i> Link Student After</label>
                            <input type="text" name="link_student_after" class="form-control" id="link_student_after" required>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="course_id" class="form-label fw-semibold"><i class="text-danger">* </i> Course</label>
                              <select class="form-control" id="course_id" name="course_id" data-placeholder="-- select one --" onchange="courseWisetrack()" required>
                                  <option value="">-- select one --</option> 
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
                            <label for="track_id" class="form-label fw-semibold"><i class="text-danger">* </i> Track Name</label>
                              <select class="form-control" id="track_id" name="track_id" data-placeholder="-- select one --" onchange="trackWiseLevel()" required>
                                  <option value="">-- select one --</option> 
                              </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="level_id" class="form-label fw-semibold"><i class="text-danger">*</i> Level</label>
                            <select class="form-control" id="level_id" name="level_id" data-placeholder="-- select level --" required> 
                              <option value="">-- select level --</option>
                          </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-2">
                            <label for="is_homework" class="form-label fw-semibold">Is Homework</label>
                          </div>
                          <input type="checkbox" class="" id="is_homework" name="is_homework">
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold"> Notes</label>
                            <textarea type="text" name="notes" class="form-control" id="notes"></textarea>
                          </div>
                        </div>
                      </div>

                        <div class="col-12">
                          <div class=" align-items-center justify-content-end mt-4 gap-3">
                            <a class="btn btn-light" href="/project">Back</a>
                            <button class="btn btn-primary float-end">Save</button>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    <script src="{{ asset('assets/modernize/libs/ckeditor/ckeditor.js') }}"></script>
    <script>
      
    // CKEditor
    // CKEDITOR.replace('notes');
   
    $(document).ready(function(){
    //   CKEDITOR.replace('notes', {
        
    //   toolbarGroups: [
    //     {
    //       "name": "basicstyles",
    //       "groups": ["basicstyles"]
    //     },
    //     {
    //       "name": "links",
    //       "groups": ["links"]
    //     },
    //     {
    //       "name": "paragraph",
    //       "groups": ["list", "blocks"]
    //     },
    //     {
    //       "name": "document",
    //       "groups": ["mode"]
    //     },
    //     {
    //       "name": "insert",
    //       "groups": ["insert"]
    //     },
    //     {
    //       "name": "styles",
    //       "groups": ["styles"]
    //     },
    //     { name: 'forms' },
    //     // { name: 'colors' },
	  //     // { name: 'tools' },
    //     {
    //       "name": "about",
    //       "groups": ["about"]
    //     }
    //   ],
    //   // Remove the redundant buttons from toolbar groups defined above.
    //   // removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
    //   removeButtons: 'Strike,Subscript,Superscript,Anchor,Specialchar'
    // });   

    CKEDITOR.replace( 'notes',
    {
        filebrowserBrowseUrl: "{{ asset('assets/modernize/libs/ckfinder/ckfinder.html') }}",
        filebrowserImageBrowseUrl: "{{ asset('assets/modernize/libs/ckfinder/ckfinder.html?type=Images') }}",
        filebrowserUploadUrl: "{{ asset('assets/modernize/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
        filebrowserImageUploadUrl: "{{ asset('assets/modernize/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}",
    });
    
    });

      function courseWisetrack(){
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