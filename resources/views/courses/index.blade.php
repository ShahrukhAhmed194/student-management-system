<x-dashboard.admin-layout>
    <x-slot name='title'>Courses - Dreamers Academy</x-slot>
      <!-- Main wrapper -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">All Courses</h5>
                            @if (Auth::guard('web')->user()->can('courses.add'))
                                <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#add-course">Add New</a>
                            @endif
                        </div>

                        <div class="table-responsive">
                        <table
                      id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'courses-datatable' : 'basic-datatable' }}"
                      class="table border table-striped table-bordered display table-responsive" style="width: 100%"
                    >
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Course Name</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                <tr>
                                    <th scope="row">{{ $course->id }}</th>
                                    <td>{{ $course->name }}</td>
                                    <td class="text-center">...</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>

                        <!--Add Course Modal -->
                        <div class="modal fade text-left" id="add-course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel1">New Course</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" action="{{ route('course.store') }}" method="POST">
                                            @csrf
                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="inputName5" class="form-label">Course Name</label>
                                                <input type="text" name="name" class="form-control" id="inputName5" required>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">Course Tracks</h5>
                            @if (Auth::guard('web')->user()->can('course_track.add'))
                                <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#add-course-track">Add New Track</a>
                            @endif
                        </div>

                        <div class="table-responsive">
                        <table
                      id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'course-track-datatable' : 'basic-datatable' }}"
                      class="table border table-striped table-bordered display table-responsive" style="width: 100%"
                    >
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Course Name</th>
                                    <th scope="col">Track Number</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course_tracks as $track)
                                <tr>
                                    <th scope="row">{{ $track->id }}</th>
                                    <td>{{ $track->course->name }}</td>
                                    <td>{{ $track->track_num }}</td>
                                    <td class="text-center">...</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>

                        <!--Add Course Modal -->
                        <div class="modal fade text-left" id="add-course-track" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel1">New Track</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" action="{{ route('course-track.store') }}" method="POST">
                                            @csrf

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="inputState" class="form-label">Course</label>
                                                <select id="inputState" name="course_id" class="form-select choices">
                                                    <option value="">Select Course</option>
                                                    @foreach($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="inputName5" class="form-label">Track Number</label>
                                                <input type="number" name="track_num" class="form-control" id="inputName5" required>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" id="title" required>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="duration" class="form-label">Duration</label>
                                                <input type="number" name="duration" class="form-control" id="duration" required>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111"></span>
                                                <label for="details" class="form-label">Details</label>
                                                <textarea name="details" class="form-control" id="details" rows="5"></textarea>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">Course Level</h5>
                            @if (Auth::guard('web')->user()->can('course_level.add'))
                            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#add-course-level">Add New Level</a>
                            @endif
                        </div>

                        <div class="table-responsive">
                        <table
                      id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'course-level-datatable' : 'basic-datatable' }}"
                      class="table border table-striped table-bordered display table-responsive" style="width: 100%"
                    >
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Course Name</th>
                                    <th scope="col">Track </th>
                                    <th scope="col">Level </th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course_levels as $level)
                                <tr>
                                    <th scope="row">{{ $level->id }}</th>
                                    <td>{{ $level->course->name }}</td>
                                    <td>{{ $level->track->track_num }}</td>
                                    <td>{{ $level->level_num }}</td>
                                    <td class="text-center">...</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>

                        <!--Add Course Modal -->
                        <div class="modal fade text-left" id="add-course-level" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel1">New Level</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" action="{{ route('course-level.store') }}" method="POST">
                                            @csrf

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="course_id" class="form-label">Course</label>
                                                <select id="course_id" name="course_id" class="form-select choices" onchange="courseWiseTrack()">
                                                    <option value="">Select Course</option>
                                                    @foreach($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="track_id" class="form-label">Track</label>
                                                <select id="track_id" name="track_id" class="form-select choices">
                                                    <option value="">Select Track</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="inputName5" class="form-label">Level Number</label>
                                                <input type="number" name="level_num" class="form-control" id="inputName5" required>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" name="title" class="form-control" id="title" required>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111">*</span>
                                                <label for="duration" class="form-label">Duration</label>
                                                <input type="number" name="duration" class="form-control" id="duration" required>
                                            </div>

                                            <div class="col-md-12">
                                                <span style="color:#e41111"></span>
                                                <label for="details" class="form-label">Details</label>
                                                <textarea name="details" class="form-control" id="details" rows="5"></textarea>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <span style="color:#e41111"></span>
                                                <label for="final_outcome" class="form-label">Final Outcome</label>
                                                <input name="final_outcome" class="form-control" id="final_outcome">
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-dashboard.admin-layout>

<script>
$(document).ready(function() {
    
    // ---------------------- its for courses ----------------------
    $("#courses-datatable").DataTable({
            dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
            buttons: ["excel", "pdf", "print"],
            buttons: [
                {
                    extend: "excel",
                    title: "Courses",
                    text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                    titleAttr: 'Courses Excel File',
                    footer: true,
                    messageTop: 'Courses Report',
                    className: "btn-sm btn-sm btn-success",
                },
                {
                    extend: "print",
                    title: "Courses",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                    titleAttr: 'Courses Excel File',
                    footer: true,
                    messageTop: 'Courses Report',
                    className: "btn-sm btn-sm btn-primary",
                },
                {
                    extend: "pdf",
                    title: "Courses",
                    text: '<i class="ti ti-file-text"></i> PDF',
                    titleAttr: 'Courses PDF File',
                    footer: true,
                    messageTop: 'Courses Report',
                    className: "btn-sm btn-sm btn-secondary",
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
            ],
            scrollX: true,
            orderCellsTop: true,
            fixedHeader: true,
            lengthMenu: [
                [10, 20, 50, 100, 150, 200, 500],
                [10, 20, 50, 100, 150, 200, "All"],
            ],
            processing: true,
            sProcessing: "<span class='fas fa-sync-alt'></span>",
            serverSide: false,
            });

    // ---------------------- its for course track ----------------------
            $("#course-track-datatable").DataTable({
            dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
            buttons: ["excel", "pdf", "print"],
            buttons: [
                {
                    extend: "excel",
                    title: "Course Track",
                    text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                    titleAttr: 'Course Track Excel File',
                    footer: true,
                    messageTop: 'Course Track Report',
                    className: "btn-sm btn-sm btn-success",
                },
                {
                    extend: "print",
                    title: "Course Track",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                    titleAttr: 'Course Track Excel File',
                    footer: true,
                    messageTop: 'Course Track Report',
                    className: "btn-sm btn-sm btn-primary",
                },
                {
                    extend: "pdf",
                    title: "Course Track",
                    text: '<i class="ti ti-file-text"></i> PDF',
                    titleAttr: 'Course Track PDF File',
                    footer: true,
                    messageTop: 'Course Track Report',
                    className: "btn-sm btn-sm btn-secondary",
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
            ],
            scrollX: true,
            orderCellsTop: true,
            fixedHeader: true,
            lengthMenu: [
                [10, 20, 50, 100, 150, 200, 500],
                [10, 20, 50, 100, 150, 200, "All"],
            ],
            processing: true,
            sProcessing: "<span class='fas fa-sync-alt'></span>",
            serverSide: false,
            });
    // ---------------------- its for course levels ----------------------
            $("#course-level-datatable").DataTable({
            dom: "<'row'<'col-sm-5'l><'col-sm-3'B><'col-sm-4'f>>tip",
            buttons: ["excel", "pdf", "print"],
            buttons: [
                {
                    extend: "excel",
                    title: "Course Level",
                    text: '<i class="ti ti-file-spreadsheet"></i> Excel',
                    titleAttr: 'Course Level Excel File',
                    footer: true,
                    messageTop: 'Course Level Report',
                    className: "btn-sm btn-sm btn-success",
                },
                {
                    extend: "print",
                    title: "Course Level",
                    text: '<i class="ti ti-printer fs-4"></i> Print',
                    titleAttr: 'Course Level Excel File',
                    footer: true,
                    messageTop: 'Course Level Report',
                    className: "btn-sm btn-sm btn-primary",
                },
                {
                    extend: "pdf",
                    title: "Course Level",
                    text: '<i class="ti ti-file-text"></i> PDF',
                    titleAttr: 'Course Level PDF File',
                    footer: true,
                    messageTop: 'Course Level Report',
                    className: "btn-sm btn-sm btn-secondary",
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },
            ],
            scrollX: true,
            orderCellsTop: true,
            fixedHeader: true,
            lengthMenu: [
                [10, 20, 50, 100, 150, 200, 500],
                [10, 20, 50, 100, 150, 200, "All"],
            ],
            processing: true,
            sProcessing: "<span class='fas fa-sync-alt'></span>",
            serverSide: false,
            });

            $(".buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel"
            ).addClass("btn btn-primary mr-1");

    });

    
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
</script>