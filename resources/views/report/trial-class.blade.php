<x-dashboard.admin-layout>
    <x-slot name='title'>Trial Class Admission Report - Dreamers Academy</x-slot>
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
                              <li class="breadcrumb-item" aria-current="page">Trial Class Admission Report</li>
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
                          <form action="/show-trial-class-report" method="get" >
                              <div class="row">
                                <div class="col-md-4">
                                    <label for="start_date">Applied From</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ !empty($search_params['start_date']) ? $search_params['start_date'] : '' }}" onfocusout="addParamsToUrl('start_date', this.value)">
                                    @error('start_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="end_date" >Applied To</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ !empty($search_params['end_date']) ? $search_params['end_date'] : '' }}" onfocusout="addParamsToUrl('end_date', this.value)">
                                    @error('end_date')
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
                <div class="table-responsive">
                  <table id="trial-class-rpt-datatable" class="table border table-striped table-bordered display table-responsive">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Guardian Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Occupation</th>
                        <th scope="col">Gender</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($parents as $parent)
                      <tr>
                        <td>{{ $parent->id }}</td>
                        <td>{{ $parent->gurdian_name }}</td>
                        <td>{{ $parent->phone }}</td>
                        <td>{{ $parent->email }}</td>
                        <td>{{ $parent->occupation }}</td>
                        <td>{{ $parent->gender }}</td>
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
    <script src="{{asset('assets/js/reports/trial-class-1.0.1.js')}}"></script>
    <script src="{{asset('assets/js/searchParams-1.0.0.js')}}"></script>
  </x-dashboard.admin-layout>
