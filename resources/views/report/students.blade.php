<x-dashboard.admin-layout>
    <x-slot name='title'>Students Monthly Report - Dreamers Academy</x-slot>
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
                              <li class="breadcrumb-item" aria-current="page">Students Monthly Report</li>
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
                          <form action="{{route('student-monthly-count-report')}}" method="get" >
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="start_month">Start Month</label>
                                    <input type="month" name="start_month" id="start_month" class="form-control" value="{{ request()->start_month }}" onfocusout="addParamsToUrl('start_month', this.value)">
                                    @error('start_month')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="end_month" >End Month</label>
                                    <input type="month" name="end_month" id="end_month" class="form-control" value="{{ request()->end_month }}" onfocusout="addParamsToUrl('end_month', this.value)">
                                    @error('end_month')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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
                <div class="table-responsive overflow-auto">
                  <table id="students-monthly-rpt-datatable" class="table border table-striped table-bordered display table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Month</th>
                        <th scope="col">Admitted</th>
                        <th scope="col">Terminated</th>
                        <th scope="col">On Hold</th>
                        <th scope="col">Graduated</th>
                        <th scope="col">Deleted</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($students as $key => $student)
                        <tr>
                          <td>{{++$key}}</td>
                          <td>{{$student->month}}</td>
                          <td>{{$student->admitted_count}}</td>
                          <td>{{$student->terminated_count}}</td>
                          <td>{{$student->on_hold_count}}</td>
                          <td>{{$student->graduated_count}}</td>
                          <td>{{$student->deleted_count}}</td>
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
    <script src="{{asset('assets/js/searchParams-1.0.0.js')}}"></script>
    <script src="{{asset('assets/js/data-table-1.0.1.js')}}"></script>
    <script src="{{asset('assets/js/reports/students-1.0.0.js')}}"></script>
  </x-dashboard.admin-layout>
