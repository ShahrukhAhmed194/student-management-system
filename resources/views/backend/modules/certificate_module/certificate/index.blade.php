<x-dashboard.admin-layout>

    <x-slot name="style">
        <style>
            p .ti {
                font-size: 20px;
            }
        </style>
    </x-slot>

    <x-slot name='title'>Certificate - Dreamers Academy</x-slot>

    <div class="container-fluid">
        <x-inc.breadcrumb title="Certificate" />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" class="certificate-filter-form" method="get" autocomplete="off">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="student_ids" class="form-label fw-semibold">Student</label>
                                    <input type="text"  name="student_ids" class="form-control" placeholder="Student ID's" value="{{ request()->student_ids }}" required>
                                    <small class="text-danger" style="font-size: 11px">(To get multiple students data use ',' separator like DA01,DA02)</small>
                                </div>
                                <div class="col-md-2">
                                    <label for="course_id" class="form-label col-md-12">Course</label>
                                    <select id="course_id" name="course_id" class="form-select col-md-12 select2" required>
                                        <option selected value="" disabled>Select Course</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" @if(request()->course_id == $course->id) selected @endif>{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="track_id" class="form-label col-md-12">Track</label>
                                    <select id="track_id" name="track_id" class="form-select col-md-12 select2" @if(empty(request()->track_id)) disabled @endif required>
                                        @if(!empty(request()->track_id))
                                            <option value="{{ request()->track_id }}" @if(request()->track_id == $track?->id) selected @endif>{{ $track?->track_num }}</option>
                                        @else
                                            <option selected value="" disabled>Select course first</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="level_id" class="form-label col-md-12">Level</label>
                                    <select id="level_id" name="level_id" class="form-select col-md-12 select2" @if(empty(request()->level_id)) disabled @endif required>
                                        @if(!empty(request()->level_id))
                                            <option value="{{ request()->level_id }}" @if(request()->level_id == $level?->id) selected @endif>{{ $level?->level_num }}</option>
                                        @else
                                            <option selected value="" disabled>Select course and track first</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-outline-primary certificate-filter-button" style="margin-top: 30px" >Search</button>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route('certificate.index') }}" class="btn btn-outline-danger float-end" style="margin-top: 30px" title="Reset">
                                        <i class="ti ti-reload"></i>
                                    </a>
                                </div>
                            </div>
                            @if(!empty(request()->level_id) && $level?->title == null)
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="level_title" class="form-label fw-semibold">Level title (Optional)</label>
                                        <input type="text"  name="level_title" class="form-control" placeholder="Level title" value="{{ request()->level_title }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-outline-primary certificate-filter-button" style="margin-top: 30px" >Set Title</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach($students as $student)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body overflow-auto">

                            <table class="table border table-bordered table-responsive" style="vertical-align: middle;">
                                <thead class="text-center">
                                    <tr>
                                        <th width="60%">Info</th>
                                        <th width="10%">Track</th>
                                        <th width="10%">Level</th>
                                        <th width="10%">Level Title</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="p-0 m-0"><i class="ti ti-user"></i>&nbsp;{{ $student->user?->name }}</p>
                                            <p class="p-0 m-0"><i class="ti ti-clipboard"></i>&nbsp;{{ $student->student_id }}</p>
                                            <p class="p-0 m-0"><i class="ti ti-mail"></i>&nbsp;{{ $student->user?->email }}</p>
                                            <p class="p-0 m-0"><i class="ti ti-phone"></i>&nbsp;{{ $student->parentInfo?->phone }}</p>
                                            <p class="p-0 m-0"><i class="ti ti-file-spreadsheet"></i>&nbsp;{{ $student->class?->name }}</p>
                                            <p class="p-0 m-0"><i class="ti ti-briefcase"></i>&nbsp; {{ $student->class?->coordinator?->name }}
                                            <p class="p-0 m-0"><i class="ti ti-server">&nbsp;</i>{{ $student->payment_status}}</p>
                                        </td>
                                        <td class="text-center">
                                            Track {{ $track?->track_num }}
                                        </td>
                                        <td class="text-center">
                                            Level {{ $level?->level_num }}
                                        </td>
                                        <td class="text-center">
                                            {{ $level?->title ?? request()->level_title }}
                                        </td>
                                        <td class="text-center">
                                            <div>
                                                <a style="color: #7b7d80;" href="{{ route('certificate.export.pdf', ['id' => encrypt($student->id), 'level_id' => encrypt($level?->id), 'level_title' => request()->level_title]) }}" target="_blank">
                                                    <i class="fs-4 ti ti-eye me-2"></i>View
                                                </a>
                                            </div>
                                            <div class="mt-2">
                                                <a style="color: #7b7d80;" href="{{ route('certificate.export.pdf', ['id' => encrypt($student->id), 'level_id' => encrypt($level?->id), 'level_title' => request()->level_title, 'action' => 'download']) }}">
                                                    <i class="fs-4 ti ti-download me-2"></i>Download
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $("#course_id").on('change', function () {

                    $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");

                    let course_id = $(this).val();

                    $('#level_id').attr('disabled', 'disabled');
                    $("#level_id").html(`
                        <option selected value="" disabled>Select course and track first</option>
                    `);

                    $.ajax({
                        url: "{{ route('course-wise-track') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        data: {
                            course_id: course_id
                        },
                        success: function (r) {
                            $("#track_id").removeAttr('disabled');
                            $("#track_id").html(r);
                            $(".loader-populate").html("");
                        },
                    });
                });

                $("#track_id").on('change', function () {

                    $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");

                    let track_id = $(this).val();

                    $.ajax({
                        url: "{{ route('track-wise-level') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        data: {
                            track_id: track_id
                        },
                        success: function (r) {
                            $("#level_id").html(r);
                            $("#level_id").removeAttr('disabled');
                            $(".loader-populate").html("");
                        },
                    });
                });
            });

            $(document).on('click','.certificate-filter-button', function(e) {
                e.preventDefault();
                if (!$("#level_id").val()) {
                    toastr.error('You have to select the level', 'Warning');
                }
                else {
                    $('.certificate-filter-form').submit();
                }
            });
        </script>
    </x-slot>

</x-dashboard.admin-layout>