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
                                    <li class="breadcrumb-item" aria-current="page">Edit Assessment</li>
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
                          <h4 class="mb-0">Assessment Details</h4>
                        <form action="/project-assesment/{{$assesment->id}}/edit" method="GET">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="mb-3 has-success">
                                    <label for="class_id" class="control-label">Class Name</label>
                                    <select disabled id="class_id" name="class_id" class="form-select" required>
                                        <option value="">- Please Select -</option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ $class->id == $selected['class_id'] ? 'selected' : ''}}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="project_id" class="col-form-label">Select Project</label>
                                    <select disabled id="project_id" name="project_id" class="form-select">
                                        <option selected>- Please Select -</option>
                                        @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ $project->id == $selected['project_id'] ? 'selected' : ''}}>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
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
                        <form action="{{ route('project-assesment.update', $assesment->id) }}" method="POST">
                            @csrf @method('PUT')
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Project Status</th>
                                        <th scope="col">Project Mark</th>
                                        <th scope="col">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ $assesment->student->name }}
                                            <input class="form-input" type="hidden" name="student_id" value="{{ $assesment->student->user_id }}" id="flexSwitchCheckChecked">
                                        </td>
                                        <td>
                                            <select id="inputState" name="project_status" class="form-select">
                                                <option>- Please Select -</option>
                                                <option value="DID_NOT_START" {{ $assesment->project_status == 'DID_NOT_START' ? 'selected' : '' }}>Didn't Start</option>
                                                <option value="IN_PROGRESS" {{ $assesment->project_status == 'IN_PROGRESS' ? 'selected' : '' }}>In Progress</option>
                                                <option value="COMPLETE" {{ $assesment->project_status == 'COMPLETE' ? 'selected' : '' }}>Complete</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="inputState" name="project_assesment" class="form-select">
                                                <option selected>- Please Select -</option>
                                                <option value="BELOW_AVERAGE" {{ $assesment->project_assesment == 'BELOW_AVERAGE' ? 'selected' : '' }}>Below Average</option>
                                                <option value="AVERAGE" {{ $assesment->project_assesment == 'AVERAGE' ? 'selected' : '' }}>Average</option>
                                                <option value="GOOD" {{ $assesment->project_assesment == 'GOOD' ? 'selected' : '' }}>Good</option>
                                                <option value="EXCELLENT" {{ $assesment->project_assesment == 'EXCELLENT' ? 'selected' : '' }}>Excellent</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <textarea class="form-control" name="comments" rows="5">{{ $assesment->comments }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="text-align: right">
                                <button type="submit" class="btn btn-primary">Update Assessment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.teacher-layout>