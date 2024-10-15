<x-dashboard.admin-layout>
    <x-slot name='title'>Instructor Student Count Report - Dreamers Academy</x-slot>
    <!-- Main wrapper -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">Reports</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Instructor Student Count Report</li>
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
            <div class="accordion" id="accordion_filter">
                <div class="accordion-item" >
                    <h2 class="accordion-header" id="accordion_search">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_search" aria-expanded="false" aria-controls="collapse_search">Search Here</button>
                    </h2>
                    <div id="collapse_search" class="accordion-collapse collapse" aria-labelledby="accordion_search" data-bs-parent="#accordion_filter">
                        <div class="accordion-body h-auto">
                          <form action="/show-instructor-report" method="get" >
                              <div class="row">
                                  <div class="col-md-3">
                                    <label for="teacher_id" >Teacher</label> <br>
                                    <select id="teacher_id" name="teacher_id" class="form-select select2 mb-1" onchange="addParamsToUrl('teacher_user_id', this.value)">
                                        <option value=""> Select Teacher Name</option>
                                        @foreach($teachers as $teacher)
                                            <option  value="{{ $teacher->id }}" {{$search_params['teacher_id'] == $teacher->id ? 'selected' : ''}}> {{ $teacher->name }} </option>
                                        @endforeach
                                    </select>
                                  </div>
                                  <div class="col-md-2">
                                      <button type="submit" class="btn btn-outline-primary mt-4" style="margin-top: 30px">Generate</button>
                                  </div>
                              </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="teacher-rpt-datatable" class="table border table-striped table-bordered display table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Total Students</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($students as $student)
                      <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->student_count }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <script src="{{asset('assets/js/reports/teacher-1.0.0.js')}}"></script>
    <script src="{{asset('assets/js/searchParams-1.0.0.js')}}"></script>
  </x-dashboard.admin-layout>
