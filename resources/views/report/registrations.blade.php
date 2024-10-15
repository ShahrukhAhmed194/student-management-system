<x-dashboard.admin-layout>
    <x-slot name='title'>Registration Report - Dreamers Academy</x-slot>
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
                              <li class="breadcrumb-item" aria-current="page">Registration Report</li>
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
            <div class="col-md-4 col-sm-12 col-lg-4">
                <div class="card ">
                    <div class="card-body table-responsive">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="text-center">Student Count Of Each Teacher</h5>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Teacher</th>
                            <th scope="col">Active</th>
                            <th scope="col">Terminated</th>
                            </tr>
                        </thead>
                        <tbody id="teacher_table"></tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center">Registration By Country</h5>
                  <div id="registration_by_country_chart_bar"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-12 col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card overflow-auto">
                            <div class="card-body">
                              <h5 class="text-center">Registration By Age</h5>
                              <div id="registration_by_age_chart_pie"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card overflow-auto">
                            <div class="card-body">
                              <h5 class="text-center">Registration By Gender</h5>
                              <div id="registration_by_gender_chart_pie"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/dashboards/admin-chart-4.0.0.js')}}"></script>

</x-dashboard.admin-layout>