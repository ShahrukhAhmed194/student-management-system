
<x-dashboard.teacher-layout>
    <x-slot name='title'>Project Assessment - Dreamers Academy</x-slot>
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-8">Student Project Assessment</h4>
                                <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                    <li class="breadcrumb-item" aria-current="page">Add Assessment</li>
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
                          <h4 class="m-4">Assessment Details</h4>
                        <form action="/project-assesment/create" method="GET">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="mb-3 has-success">
                                    <label class="control-label">Class Name</label>
                                    <select {{$from == 'session'?'disabled':''}} id="class_id" name="class_id" class="form-select" required>
                                        <option value="">- Please Select -</option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ $class->id == $selected['class_id'] ? 'selected' : ''}}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="mb-3 has-success">
                                    <label class="control-label">Project Name</label>
                                    <select id="project_id" name="project_id" class="form-select">
                                        <option selected>- Please Select -</option>
                                        @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ $project->id == $selected['project_id'] ? 'selected' : ''}}>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
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
                       <form action="{{ route('project-assesment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $selected['class_id'] }}">
                            <input type="hidden" name="teacher_id" value="{{ $selected['teacher_id'] }}">
                            <input type="hidden" name="project_id" value="{{ $selected['project_id'] }}">
                            <input type="hidden" name="is_homework" value="{{ $selected['is_homework'] }}">
                            <input type="hidden" name="from" value="{{ $from }}">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Project Status</th>
                                        <th scope="col">Project Assessment</th>
                                        <th scope="col">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if ($count == 0)
                                    @foreach($students as $key=>$student)
                                    <tr>
                                        <td>
                                            {{ $student->user->name }}
                                            <input class="form-input" type="hidden" name="assesments[{{ $key}}][student_id]" value="{{ $student->user_id }}" id="flexSwitchCheckChecked">
                                        </td>
                                        <td>
                                            <select id="assesments[{{ $key}}][project_status]" name="assesments[{{ $key}}][project_status]" class="form-select" required>
                                                <option disabled selected value="">- Please Select -</option>
                                                <option value="DID_NOT_START">Didn't Start</option>
                                                <option value="IN_PROGRESS">In Progress</option>
                                                <option value="COMPLETE">Complete</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="assesments[{{ $key}}][project_assesment]" name="assesments[{{ $key}}][project_assesment]" class="form-select" required>
                                                <option disabled selected value="">- Please Select -</option>
                                                <option value="BELOW_AVERAGE">Below Average</option>
                                                <option value="AVERAGE">Average</option>
                                                <option value="GOOD">Good</option>
                                                <option value="EXCELLENT">Excellent</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <textarea class="form-control" name="assesments[{{ $key}}][comments]" rows="5" required></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    @foreach($students as $key=>$student)
                                        <tr>
                                            <td>
                                                {{ $student->student->name }}
                                                <input type="hidden" name="assesments[{{ $key}}][id]" id="assesments[{{ $key}}][id]" value="{{$student->id}}">
                                                <input class="form-input" type="hidden" name="assesments[{{ $key}}][student_id]" value="{{ $student->student->id }}" id="flexSwitchCheckChecked">
                                            </td>
                                            <td>
                                                <select id="assesments[{{ $key}}][project_status]" name="assesments[{{ $key}}][project_status]" class="form-select" required>
                                                    <option disabled selected value="">- Please Select -</option>
                                                    <option {{$student->project_status == 'DID_NOT_START'? 'selected': ''}} value="DID_NOT_START">Didn't Start</option>
                                                    <option {{$student->project_status == 'IN_PROGRESS'? 'selected': ''}} value="IN_PROGRESS">In Progress</option>
                                                    <option {{$student->project_status == 'COMPLETE'? 'selected': ''}} value="COMPLETE">Complete</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="assesments[{{ $key}}][project_assesment]" name="assesments[{{ $key}}][project_assesment]" class="form-select" required>
                                                    <option disabled selected value="">- Please Select -</option>
                                                    <option {{$student->project_assesment == 'BELOW_AVERAGE' ? 'selected' : ''}} value="BELOW_AVERAGE">Below Average</option>
                                                    <option {{$student->project_assesment == 'AVERAGE' ? 'selected' : ''}} value="AVERAGE">Average</option>
                                                    <option {{$student->project_assesment == 'GOOD' ? 'selected' : ''}} value="GOOD">Good</option>
                                                    <option {{$student->project_assesment == 'EXCELLENT' ? 'selected' : ''}} value="EXCELLENT">Excellent</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <textarea class="form-control" name="assesments[{{ $key}}][comments]" rows="5" required>{{$student->comments}}</textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="m-3">
                                <div class="col-12">
                                    <div class=" align-items-center justify-content-end mt-4 gap-3">
                                      <a class="btn btn-light" href="/project-assesment">Back</a>
                                      <button class="btn btn-primary float-end">Save</button>
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
