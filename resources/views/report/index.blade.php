<x-dashboard.admin-layout>
    <x-slot name='title'>Comprehensive Report - Dreamers Academy</x-slot>
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
                              <li class="breadcrumb-item" aria-current="page">Comprehensive Report</li>
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
                        <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse_search"
                        aria-expanded="false"
                        aria-controls="collapse_search"
                        >
                        Search Here
                        </button>
                    </h2>
                    <div id="collapse_search" class="accordion-collapse collapse" aria-labelledby="accordion_search" data-bs-parent="#accordion_filter">
                        <div class="accordion-body h-auto">
                            <form action="/report-show-date-status-count" method="POST" >
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="from_date" class="form-label">Start Date</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control" value="{{empty(Session::get('searched_data')['start_date'])? '' : Session::get('searched_data')['start_date']}}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="to_date" class="form-label">End Date</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control" value="{{empty(Session::get('searched_data')['end_date'])? '' : Session::get('searched_data')['end_date']}}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-outline-primary" style="margin-top: 33px">Generate</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($total_count as $count)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-title fw-semibold ms-4 mt-4">All Status</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="item">
                                      <div class="card bg-light-primary">
                                        <div class="card-body">
                                          <div class="text-center">
                                            <img src="{{asset('assets/modernize/images/svgs/icon-form.svg')}}" width="50" height="50" class="mb-3" alt="" />
                                            <p class="fw-semibold fs-3 text-primary mb-1"> Total </br> Registrations </p>
                                            <h6 id="no_total_registration" class="card-title fs-18 font-weight-bold">
                                                {{$count->Registered}}
                                            </h6>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <div class="item">
                                      <div class="card bg-light-secondary">
                                        <div class="card-body">
                                          <div class="text-center">
                                            <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                                            <p class="fw-semibold fs-3 text-secondary mb-1"> Total </br> Attended </p>
                                            <h6 id="no_total_registration" class="card-title fs-18 font-weight-bold">
                                                {{$count->Attended}}
                                            </h6>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <div class="item">
                                      <div class="card bg-light-success">
                                        <div class="card-body">
                                          <div class="text-center">
                                            <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                                            <p class="fw-semibold fs-3 text-success mb-1"> Total </br> Admitted </p>
                                            <h6 id="no_total_registration" class="card-title fs-18 font-weight-bold">
                                                {{$count->Admitted}}
                                            </h6>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <div class="item">
                                      <div class="card bg-light-danger">
                                        <div class="card-body">
                                          <div class="text-center">
                                            <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                                            <p class="fw-semibold fs-3 text-danger mb-1"> Total </br> Absent </p>
                                            <h6 id="no_total_registration" class="card-title fs-18 font-weight-bold">
                                                {{$count->Absent}}
                                            </h6>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row {{empty($count) ? 'mt-4' : ''}}">
            <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
                        <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'report-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Registered</th>
                                    <th scope="col">Attended</th>
                                    <th scope="col">Absent</th>
                                    <th scope="col">Refused Admission</th>
                                    <th scope="col">Will Admit Later</th>
                                    <th scope="col">Admitted</th>
                                    <th scope="col">Rescheduled</th>
                                    <th scope="col">Will Attend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collection as $item)
                                <tr>
                                    <td>{{$item->Date}}</td>
                                    <td>{{$item->Registered}}</td>
                                    <td>{{$item->Attended}}</td>
                                    <td>{{$item->Absent}}</td>
                                    <td>{{$item->RefusedAdmission}}</td>
                                    <td>{{$item->WillAdmitLater}}</td>
                                    <td>{{$item->Admitted}}</td>
                                    <td>{{$item->Rescheduled}}</td>
                                    <td>{{$item->WillAttend}}</td>
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
  <script src="{{asset('assets/js/reports/print-file-1.0.0.js')}}"></script>
</x-dashboard.admin-layout>
