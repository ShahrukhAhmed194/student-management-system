<x-dashboard.admin-layout>
    <x-slot name='title'>Sales Report - Dreamers Academy</x-slot>
    @php
       $startDate = (!empty($_GET['start_date']) ? $_GET['start_date'] : '');
       $endDate = (!empty($_GET['end_date']) ? $_GET['end_date'] : '');
    @endphp
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
                              <li class="breadcrumb-item" aria-current="page">Sales Report</li>
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
                          <form action="/show-sales-report" method="get" >
                              <div class="row">
                                  <div class="col-md-5">
                                      <label for="start_date" class="form-label">Start Date</label>
                                      <input type="date" id="start_date" name="start_date" class="form-control" value="{{ (!empty($startDate) ? $startDate : old('start_date')) }}" onfocusout="addParamsToUrl('start_date', this.value)">
                                      @error('start_date')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                      @enderror
                                  </div>
                                  <div class="col-md-5">
                                      <label for="end_date" class="form-label">End Date</label>
                                      <input type="date" id="end_date" name="end_date" class="form-control" value="{{ (!empty($endDate) ? $endDate : old('end_date')) }}" onfocusout="addParamsToUrl('end_date', this.value)">
                                      @error('end_date')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                      @enderror
                                      @error('date_range')
                                        <span class="text-danger font-weight-bold">{{ $message }}</span>
                                      @enderror
                                  </div>
                                  <div class="col-md-2">
                                      <button type="submit" class="btn btn-outline-primary" style="margin-top: 30px">Generate</button>
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
                        <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'sales-rpt-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Mushfiq</th>
                                    <th scope="col">Fahmida</th>
                                    <th scope="col">Shammi</th>
                                    <th scope="col">Mehjabin</th>
                                    <th scope="col">Sakil</th>
                                    <th scope="col">Anjon</th>
                                    <th scope="col">YSSE</th>
                                    <th scope="col">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($reports as $report)
                              <tr>
                                  <td>{{ $report->date }}</td>
                                  <td>{{ $report->Mushfiq }}</td>
                                  <td>{{ $report->Fahmida }}</td>
                                  <td>{{ $report->Shammi }}</td>
                                  <td>{{ $report->Mehjabin }}</td>
                                  <td>{{ $report->Sakil }}</td>
                                  <td>{{ $report->Anjon }}</td>
                                  <td>{{ $report->YSSE }}</td>
                                  <td>{{ $report->Mushfiq + $report->Fahmida + $report->Shammi + $report->Mehjabin + $report->Sakil + $report->Anjon, $report->YSSE }}</td>
                              </tr>
                              @endforeach
                              
                              @if($reportsTotalSalesSum)
                                <tr>
                                  <th>Total</th>
                                  <th>{{ (!empty($reportsTotalSalesSum[0]->mushfiqTotalSale) ? $reportsTotalSalesSum[0]->mushfiqTotalSale : 0) }}</th>
                                  <th>{{ (!empty($reportsTotalSalesSum[0]->fahmidaTotalSale) ? $reportsTotalSalesSum[0]->fahmidaTotalSale : 0) }}</th>
                                  <th>{{ (!empty($reportsTotalSalesSum[0]->shammiTotalSale) ? $reportsTotalSalesSum[0]->shammiTotalSale : 0) }}</th>
                                  <th>{{ (!empty($reportsTotalSalesSum[0]->mehjabinTotalSale) ? $reportsTotalSalesSum[0]->mehjabinTotalSale : 0) }}</th>
                                  <th>{{ (!empty($reportsTotalSalesSum[0]->shakilTotalSale) ? $reportsTotalSalesSum[0]->shakilTotalSale : 0) }}</th>
                                  <th>{{ (!empty($reportsTotalSalesSum[0]->anjonTotalSale) ? $reportsTotalSalesSum[0]->anjonTotalSale : 0) }}</th>
                                  <th>{{ (!empty($reportsTotalSalesSum[0]->YSSETotalSale) ? $reportsTotalSalesSum[0]->YSSETotalSale : 0) }}</th>
                                  <th>{{ ($reportsTotalSalesSum[0]->mushfiqTotalSale + $reportsTotalSalesSum[0]->fahmidaTotalSale + $reportsTotalSalesSum[0]->shammiTotalSale + $reportsTotalSalesSum[0]->mehjabinTotalSale + $reportsTotalSalesSum[0]->shakilTotalSale + $reportsTotalSalesSum[0]->anjonTotalSale + $reportsTotalSalesSum[0]->YSSETotalSale) }}</th>
                                </tr>
                              @endif
                            </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    <script src="{{asset('assets/js/reports/sales-1.0.1.js')}}"></script>
  </x-dashboard.admin-layout>
