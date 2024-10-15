<x-dashboard.admin-layout>
    <x-slot name='title'>Due Report - Dreamers Academy</x-slot>
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
                              <li class="breadcrumb-item" aria-current="page">Due Report</li>
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
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive overflow-auto">
                  <table id="due-rpt-datatable" class="table border table-striped table-bordered display table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Class</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Due Installments</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($students as $key => $student)
                        <tr>
                          <td>{{++$key}}</td>
                          <td>{{$student->student_id}}</td>
                          <td>{{$student->name}}</td>
                          <td>{{$student->due_date}}</td>
                          <td>{{$student->due_installments}}</td>
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
    <script src="{{asset('assets/js/data-table-1.0.1.js')}}"></script>
    <script src="{{asset('assets/js/reports/due-1.0.0.js')}}"></script>
  </x-dashboard.admin-layout>
