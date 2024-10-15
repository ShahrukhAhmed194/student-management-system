<x-dashboard.teacher-layout>
    <x-slot name='title'>Attendance - Dreamers Academy</x-slot>
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-8">Student Attendance</h4>
                                <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                    <li class="breadcrumb-item" aria-current="page">Edit Attendance</li>
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
                <div class="col-md-7">
                    <div class="card">
                          <h4 class="m-4">Class Details</h4>
                        <form action="/attendance/{{$attendance->id}}/edit" method="GET">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="mb-3 has-success">
                                    <label class="control-label">Class Name</label>
                                    <select disabled id="class_id" name="class_id" class="form-control custom-select" required>
                                        <option value="">- Please Select -</option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ $class->id == $selected['class_id'] ? 'selected' : ''}}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="mb-3">
                                    <label class="control-label">Date</label>
                                    <input disabled type="date" name="date" value="{{ $selected['date'] }}" class="form-control" required>
                                  </div>
                                </div>
                                <div class="col-sm-10">
                                </div>
                                <div class="col-sm-2">
                                    <div class="col-12">
                                        <div class=" align-items-center justify-content-end mt-4 gap-3">
                                          <button class="btn btn-primary float-end">Submit</button>
                                        </div>
                                      </div>
                                </div>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="class_id" value="{{ $selected['class_id'] }}">
                            <input type="hidden" name="teacher_id" value="{{ $selected['teacher_id'] }}">
                            <input type="hidden" name="date" value="{{ $selected['date'] }}">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Present</th>
                                        <th scope="col">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ $attendance->student->name }}
                                            <input class="form-input" type="hidden" name="student_id" value="{{ $attendance->student_id }}" id="flexSwitchCheckChecked">
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="hidden" value="0" name="status">
                                                <input class="form-check-input" type="checkbox" name="status" value="1" id="flexSwitchCheckChecked" {{ $attendance->status == true ? 'checked' : ''}}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <textarea class="form-control" name="comment" rows="2">{{$attendance->comments}}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                <!-- End Table with stripped rows -->
                                <div class="m-3">
                                    <div class="col-12">
                                        <div class=" align-items-center justify-content-end mt-4 gap-3">
                                          <a class="btn btn-light" href="/attendance">Back</a>
                                          <button type="submit" class="btn btn-primary float-end">Save</button>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.teacher-layout>