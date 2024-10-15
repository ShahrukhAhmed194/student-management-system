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
                                    <li class="breadcrumb-item" aria-current="page">Add Attendance</li>
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
                          <h4 class="m-4 card-title fw-semibold">Class Details</h4>
                        <form action="/attendance/create" method="GET">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="mb-3 has-success">
                                    <label class="control-label">Class Name</label>
                                    <select {{$from == 'session'?'disabled':''}} id="class_id" name="class_id" class="form-select" required>
                                        <option value="">- Please Select -</option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ $class->id == $lists['selected']['class_id'] ? 'selected' : ''}}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="mb-3">
                                    <label class="control-label">Date</label>
                                    <input type="date" {{$from == 'session'?'disabled':''}} name="date" id="date" value="{{ $lists['selected']['date'] }}" class="form-control" required />
                                  </div>
                                </div>
                                <div class="col-sm-10">
                                </div>
                                <div class="col-sm-2">
                                    <div class="col-12">
                                        <div class=" align-items-center justify-content-end mt-4 gap-3">
                                            <button type="submit" class="btn btn-primary float-end">Submit</button>
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
                        <form action="{{ route('attendance.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $lists['selected']['class_id'] }}">
                            <input type="hidden" name="teacher_id" value="{{ $lists['selected']['teacher_id'] }}">
                            <input type="hidden" name="date" value="{{ $lists['selected']['date'] }}">
                            <input type="hidden" name="from" value="{{ $from }}">
                            <div class="card-body table-responsive overflow-auto">
                                <!-- Table with stripped rows -->
                                <table class="table border table-striped table-bordered display text-nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Name</th>
                                            <th scope="col" class="text-center">Present</th>
                                            <th scope="col" class="text-center">Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($lists['count'] == 0)
                                            @foreach($lists['students'] as $key=>$student)
                                            <tr>
                                                <td>
                                                    {{ $student->user->name }}
                                                    <input type="hidden" name="attendances[{{ $key}}][student_id]" value="{{ $student->user->id }}" >
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" value="0" name="attendances[{{ $key}}][status]">
                                                    <input class="form-check-input" type="checkbox" name="attendances[{{ $key}}][status]" value="1" checked>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <textarea class="form-control" name="attendances[{{ $key}}][comment]" rows="2"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            @foreach($lists['attendances'] as $key=>$attendance)
                                            <tr>
                                                <td>
                                                    {{ $attendance->student->name }}
                                                    <input type="hidden" name="attendances[{{ $key}}][student_id]" value="{{$attendance->student->id }}">
                                                </td>
                                                <td class="text-center">
                                                    <input type="hidden" value="0" name="attendances[{{ $key}}][status]">
                                                    <input class="form-check-input" type="checkbox" name="attendances[{{ $key}}][status]" value="1" {{$attendance->status == 1? 'checked': 'unchecked' }}>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <textarea class="form-control" name="attendances[{{ $key}}][comment]" rows="2">{{$attendance->comments}}</textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->
                            </div>
                            <div class="m-3">
                                <div class="col-12">
                                    <div class=" align-items-center justify-content-end mt-4 gap-3">
                                      <a class="btn btn-light" href="/attendance">Back</a>
                                      <button type="submit" class="btn btn-primary float-end">Save</button>
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