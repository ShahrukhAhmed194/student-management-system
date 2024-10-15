<x-dashboard.admin-layout>
  <x-slot name='title'>Dashboard - Dreamers Academy</x-slot>
  <!-- Main wrapper -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2">
          <div class="item">
            <div class="card bg-success">
              <div class="card-body">
                <div class="text-center">
                  <img src="{{asset('assets/modernize/images/svgs/icon-mailbox.svg')}}" width="50" height="50" class="mb-3" alt="" />
                  <p class="fw-semibold fs-3 text-dark mb-1"> My </br>Work List</p>
                  <h6 id="no_total_myWorkList" class="card-title fs-18 font-weight-bold">
                    <a href="/my-work-list" id="total_myWorkList" class="text-dark"></a>
                  </h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row card-list"
           data-total-registration="{{ can('trial_class.list') ? "true" : "false"  }}"
           data-total-students="{{ can('students.list') ? "true" : "false"  }}"
           data-active-students="{{ can('admitted_student.list') ? "true" : "false"  }}"
           data-on-hold-students="{{ can('on_hold_students.list') ? "true" : "false"  }}"
           data-terminated-students="{{ can('terminated_student.list') ? "true" : "false"  }}"
           data-graduated-students="{{ can('graduated_student.list') ? "true" : "false"  }}"
           data-trial-class-students-yesterday="{{ can('trial_class_student_yesterday.list') ? "true" : "false"  }}"
           data-trial-class-students-today="{{ can('trial_class_student_today.list') ? "true" : "false"  }}"
           data-trial-class-students-tomorrow="{{ can('trial_class_student_tomorrow.list') ? "true" : "false"  }}"
           data-student-payment-received="{{ can('student_received_payment.list') ? "true" : "false"  }}"
           data-student-payment-due="{{ can('student_due_payment.list') ? "true" : "false"  }}"
      >
        @can('trial_class.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-info">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-form.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Total </br> Registrations </p>
                    <h6 id="no_total_registration" class="card-title fs-18 font-weight-bold">
                      <a href="/trial-class" id="total_registration" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('trial_class_student_yesterday.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-warning">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-laptop.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Yesterday's </br> Trial Classes </p>
                    <h6 id="no_trial_class_students_yesterday" class="card-title fs-18 font-weight-bold">
                      <a href="/show-trial-class-students-yesterday" id="trial_class_students_yesterday" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('trial_class_student_today.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-success">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-laptop.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1">Today's </br> Trial Classes</p>
                    <h6 id="no_trial_class_students_today" class="card-title fs-18 font-weight-bold">
                      <a href="/show-trial-class-students-today" id="trial_class_students_today" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('trial_class_student_tomorrow.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-primary">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-laptop.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1">Tomorrow's </br> Trial Classes</p>
                    <h6 id="no_trial_class_students_tomorrow" class="card-title fs-18 font-weight-bold">
                      <a href="/show-trial-class-students-tomorrow" id="trial_class_students_tomorrow" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan
      </div>

      <div class="row">
        @can('students.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-secondary">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Total </br> Students </p>
                    <h6 id="no_total_students" class="card-title fs-18 font-weight-bold">
                      <a href="/show-total-students" id="total_students" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('admitted_student.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-success">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Active </br> Students </p>
                    <h6 id="no_active_students" class="card-title fs-18 font-weight-bold">
                      <a href="/students" id="active_students" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('dashboard_student_not_assigned')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-primary">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Student </br> not assigned </p>
                    <h6 id="student_not_assigned" class="card-title fs-18 font-weight-bold">
                      0
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('on_hold_students.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-warning">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Students</br> On Hold </p>
                    <h6 id="no_students_on_hold" class="card-title fs-18 font-weight-bold">
                      <a href="/show-students-on-hold" id="students_on_hold" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('terminated_student.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-danger">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Terminated </br> Students </p>
                    <h6 id="no_terminated_students" class="card-title fs-18 font-weight-bold">
                      <a href="students-terminated" id="terminated_students" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('graduated_student.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-secondary">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-user-male.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Graduated </br> Students </p>
                    <h6 id="no_graduated_students" class="card-title fs-18 font-weight-bold">
                      <a href="/students-graduated" id="graduated_students" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan
      </div>

      <div class="row">
        @can('student_received_payment.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-success">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Received </br> Payments </p>
                    <h6 id="no_payment_received" class="card-title fs-18 font-weight-bold">
                      <a href="/show-payment-received-students" id="payment_received" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan
        @can('dashboard_advanced_payment')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-secondary">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Advanced </br> Payments </p>
                    <h6 id="advanced_payment" class="card-title fs-18 font-weight-bold">
                      0
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan
        @can('dashboard_non_advanced_payment')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-info">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1">Non Advanced </br> Payments </p>
                    <h6 id="non_advanced_payment" class="card-title fs-18 font-weight-bold">
                      0
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan
        @can('dashboard_wrong_payment')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-danger">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Wrong </br> Payments </p>
                    <h6 id="wrong_payment" class="card-title fs-18 font-weight-bold">
                      0
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan
      </div>

      <div class="row">
        @can('student_due_payment.list')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-danger">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Due </br> Payments </p>
                    <h6 id="no_due_payments" class="card-title fs-18 font-weight-bold">
                      <a href="/show-due-payment-students" id="due_payments" class="text-dark"></a>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('dashboard_month_due')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-secondary">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> 1 Month </br> Due </p>
                    <h6 id="one_month_due" class="card-title fs-18 font-weight-bold">
                      0
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('dashboard_month_due')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-primary">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> 2 Month </br> Due </p>
                    <h6 id="two_month_due" class="card-title fs-18 font-weight-bold">
                      0
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('dashboard_month_due')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-warning">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> 3+ Month </br> Due </p>
                    <h6 id="three_plus_month_due" class="card-title fs-18 font-weight-bold">
                      0
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

        @can('dashboard_wrong_due')
          <div class="col-md-2">
            <div class="item">
              <div class="card bg-danger">
                <div class="card-body">
                  <div class="text-center">
                    <img src="{{asset('assets/modernize/images/svgs/icon-paypal.svg')}}" width="50" height="50" class="mb-3" alt="" />
                    <p class="fw-semibold fs-3 text-dark mb-1"> Wrong </br> Due </p>
                    <h6 id="wrong_due" class="card-title fs-18 font-weight-bold">
                      0
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endcan

      </div>
    </div>

  <x-slot name="script">

    <script src="{{asset('assets/js/dashboards/admin-2.4.4.js')}}"></script>

    <script>
      @can('dashboard_student_not_assigned')
        $.ajax({
          type: "GET",
          url: "{{ route('get.students.not.assigned.count') }}",
          success: function(res) {
            if (res <= 0) {
              return false;
            }
            $('#student_not_assigned').html(
                studentHref("{{ route('students.index', ['filter' => 'student_not_assigned']) }}", res)
            );
          }
        });
      @endcan

      @can('dashboard_advanced_payment')
        $.ajax({
          type: "GET",
          url: "{{ route('get.advanced.payment.count') }}",
          success: function(res) {
            if (res <= 0) {
              return false;
            }
            $('#advanced_payment').html(
                studentHref("{{ route('students.index', ['filter' => 'advanced_payment']) }}", res)
            );
          }
        });
      @endcan

      @can('dashboard_non_advanced_payment')
        $.ajax({
          type: "GET",
          url: "{{ route('get.non.advanced.payment.count') }}",
          success: function(res) {
            if (res <= 0) {
              return false;
            }
            $('#non_advanced_payment').html(
                studentHref("{{ route('students.index', ['filter' => 'non_advanced_payment']) }}", res)
            );
          }
        });
      @endcan

      @can('dashboard_wrong_payment')
        $.ajax({
          type: "GET",
          url: "{{ route('get.wrong.payment.count') }}",
          success: function(res) {
            if (res <= 0) {
              return false;
            }
            $('#wrong_payment').html(
                studentHref("{{ route('students.index', ['filter' => 'wrong_payment']) }}", res)
            );
          }
        });
      @endcan

      @can('dashboard_month_due')
        $.ajax({
          type: "GET",
          url: "{{ route('get.month.due.count', ['month' => encrypt(1)]) }}",
          success: function(res) {
            if (res <= 0) {
              return false;
            }
            $('#one_month_due').html(
                studentHref("{{ route('students.index', ['filter' => 'month_due', 'month' => 1]) }}", res)
            );
          }
        });
      @endcan

      @can('dashboard_month_due')
        $.ajax({
          type: "GET",
          url: "{{ route('get.month.due.count', ['month' => encrypt(2)]) }}",
          success: function(res) {
            if (res <= 0) {
              return false;
            }
            $('#two_month_due').html(
                studentHref("{{ route('students.index', ['filter' => 'month_due', 'month' => 2]) }}", res)
            );
          }
        });
      @endcan

      @can('dashboard_month_due')
        $.ajax({
          type: "GET",
          url: "{{ route('get.month.due.count', ['month' => encrypt(3)]) }}",
          success: function(res) {
            if (res <= 0) {
              return false;
            }
            $('#three_plus_month_due').html(
                studentHref("{{ route('students.index', ['filter' => 'month_due', 'month' => 3]) }}", res)
            );
          }
        });
      @endcan

      @can('dashboard_wrong_due')
        $.ajax({
          type: "GET",
          url: "{{ route('get.wrong.due.count') }}",
          success: function(res) {
            if (res <= 0) {
              return false;
            }
            $('#wrong_due').html(
                studentHref("{{ route('students.index', ['filter' => 'wrong_due']) }}", res)
            );
          }
        });
      @endcan

      function studentHref(url, data) {
        return `<a @can('admitted_student.list') href="${url}" @endcan class="text-dark">${data}</a>`
      }
    </script>
  </x-slot>
</x-dashboard.admin-layout>