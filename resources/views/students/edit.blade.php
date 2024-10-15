<x-dashboard.admin-layout>

    <x-slot name='title'>Update Student - Dreamers Academy</x-slot>
        <div class="container-fluid">
          
          <div class="row">
              <div class="col-12 mt-xxl-n4">
                  <div class="card position-relative overflow-hidden">
                      <div class="card-body px-4 py-3">
                        <div class="row align-items-center">
                          <div class="col-9">
                            <h4 class="fw-semibold mb-8">Update Student | <span class="fs-4">{{$student->user->name}}</span></h4>
                            <nav aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">Edit Student</li>
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
              @if($student->admitted_on)
                <div class="col-md-2">
                  <div class="item">
                    <div class="card bg-primary">
                      <div class="card-body">
                        <div class="text-center">
                          <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                          <p class="fw-semibold fs-3 text-dark mb-1"><b> Admitted On </b></br> {{ date('d M, Y', strtotime($student->admitted_on ))}}<br>
                          <b> By {{empty($student->admittedBy->name) ? '' : $student->admittedBy->name }} </b></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($student->updated_at)
                <div class="col-md-2">
                  <div class="item">
                    <div class="card bg-secondary">
                      <div class="card-body">
                        <div class="text-center">
                          <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                          <p class="fw-semibold fs-3 text-dark mb-1"><b> Updated On </b></br> {{ date('d M, Y', strtotime($student->updated_at))}}<br>
                          <b> By {{empty($student->updatedBy->name) ? '' : $student->updatedBy->name }} </b></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($student->graduated_on)
                <div class="col-md-2">
                  <div class="item">
                    <div class="card bg-success">
                      <div class="card-body">
                        <div class="text-center">
                          <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                          <p class="fw-semibold fs-3 text-dark mb-1"><b> Graduated On </b></br> {{ date('d M, Y', strtotime($student->graduated_on))}}<br>
                          <b> By {{empty($student->graduatedBy->name) ? '' : $student->graduatedBy->name }} </b></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($student->on_hold_since)
                <div class="col-md-2">
                  <div class="item">
                    <div class="card bg-warning">
                      <div class="card-body">
                        <div class="text-center">
                          <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                          <p class="fw-semibold fs-3 text-dark mb-1"><b> On Hold On</b></br> {{ date('d M, Y', strtotime($student->on_hold_since))}}<br>
                          <b> By {{empty($student->onHoldBy->name) ? '' : $student->onHoldBy->name }}</b> </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($student->terminated_on)
                <div class="col-md-2">
                  <div class="item">
                    <div class="card bg-danger">
                      <div class="card-body">
                        <div class="text-center">
                          <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                          <p class="fw-semibold fs-3 text-dark mb-1"><b> Terminated On </b></br> {{ date('d M, Y', strtotime($student->terminated_on))}}<br>
                          <b> By {{empty($student->terminatedBy->name) ? '' : $student->terminatedBy->name }} </b></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($student->deleted_on)
                <div class="col-md-2">
                  <div class="item">
                    <div class="card bg-danger">
                      <div class="card-body">
                        <div class="text-center">
                          <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                          <p class="fw-semibold fs-3 text-dark mb-1"><b> Deleted On </b></br> {{ date('d M, Y', strtotime($student->deleted_on))}}<br>
                          <b> By {{empty($student->deletedBy->name) ? '' : $student->deletedBy->name }}</b></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
          </div>
          <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                      @foreach($tabs as $key => $tab)
                          <li class="nav-item @if($key == 0) first_tab @endif">
                              <a href="#custom_tab" class="nav-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 text-body-color
                                  @if($key == 0) active @endif" data-bs-toggle="tab" role="tab"
                                  data-content="{{ route($tab['route'], ['id' => $student->id]) }}">
                                  <span><i class="ti {{ $tab['icon'] }} fs-4"></i></span>
                                  <span class="d-none d-md-block font-weight-medium">{{ $tab['name'] }}</span>
                              </a>
                          </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="" id="custom_tab">
                  <div class="tab-pane tab-content" role="tabpanel">
  
                  </div>
                </div>
              </div>
          </div>
        </div>
    </section>
    <script src="{{asset('assets/js/students/status-functions-3.1.1.js?v=1')}}"></script>
    <script src="{{asset('assets/js/ajax_tab-1.0.1.js')}}"></script>
</x-admin-layout>
