<x-admin-layout>
    <div class="pagetitle">
        <h1 class="text-center">Missing Session</h1>
    </div>
    <!-- End Page Title -->
    <style>
        .card{
            margin-bottom: 0;
        }
    </style>
    <section class="section">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <form class="row g-3" action="{{ route('session-save') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add Session</h5>
                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="teacher_id" class="form-label mt-2">Teacher : </label>
                                <select id="teacher_id" name="teacher_id" class="form-select select2" onchange="teacherWiseClass(this.value)" required>
                                    <option value="">
                                        Select Teacher
                                    </option>
                                    <?php foreach($allResults['getTeacherInfo'] as $teacher){ ?>
                                        <option  value="{{ $teacher->id }}">
                                            {{ $teacher->name }}
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="class_id" class="form-label mt-2">Class : </label>
                                <select id="class_id" name="class_id" class="form-select select2" required>
                                    <option value="">
                                        Select Class
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="session_date" class="form-label mt-1">Session Date : </label>
                                <input type="date" class="form-control" id="session_date" name="session_date" required>
                            </div>
                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="session_started" class="form-label mt-2">Session Started : </label>
                                <input type="time" class="form-control" id="session_started" name="session_started" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                                <div class=" align-items-center justify-content-end mt-3">
                                  <a class="btn btn-light" href="/update-recording-list">Back</a>
                                  <button type="submit" class="btn btn-primary float-end">Submit</button>
                                </div>
                              </div>
                        </div>
                    </div>
                </form><!-- End Multi Columns Form -->
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"></div>
        </div>
    </section>
    <script>
        function teacherWiseClass(teacher_id){
            $.ajax({
            url: "/teacher-wise-classes",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            data: {
                teacher_id: teacher_id
            },
            success: function (r) {
                $("#class_id").html(r);
            },
            });
        }
    </script>
</x-admin-layout>