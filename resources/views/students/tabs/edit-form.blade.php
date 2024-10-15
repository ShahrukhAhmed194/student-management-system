@php
$usr = Auth::guard('web')->user();
@endphp
<div class="tab-pane active" role="tabpanel">
    <div class="row">
      <div class="col-md-12">
        <div class="card w-100 position-relative overflow-hidden mb-0">
          <div class="px-4 py-3 border-bottom">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Student Edit</h5>
          </div>
          <div class="card-body p-4">
            <form action="{{ route('students.update', $student->id) }}" method="POST" id="update_student" class="row g-3" >
              @csrf @method('PUT')
              <div class="row">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold"><i class="text-danger"> * </i> Name</label>
                        <input type="text" name="name" value="{{ $student->user->name }}" class="form-control" id="name">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-4">
                    <label for="user_name" class="form-label fw-semibold"><i class="text-danger">* </i>User Name</label>
                    <input type="text" name="user_name" value="{{$student->user->user_name}}" class="form-control" id="user_name">
                    @error('user_name')
                        <div class="text-danger ">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="mb-4">
                    <label for="email" class="form-label fw-semibold"><i class="text-danger">* </i>Emal</label>
                    <input type="email" name="email" value="{{$student->user->email}}" class="form-control" id="email">
                    @error('email')
                        <div class="text-danger ">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold"><i class="text-danger">* </i>Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                        @error('password')
                            <div class="text-danger ">{{ $message }}</div>
                        @enderror
                        <input type="hidden" id="status" name="status" value="{{$student->status}}">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="user_type" class="form-label fw-semibold"><i class="text-danger"> * </i>User Type</label>
                      <select id="user_type" name="user_type" class="form-control select2">
                        <option value="Student" selected>Student</option>
                      </select>
                      @error('user_type')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="gender" class="form-label fw-semibold"><i class="text-danger"> * </i>Gender</label>
                      <select id="gender" name="gender" title="gender" class="form-control select2">
                        <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                      </select>
                      @error('gender')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                    <div class="mb-4">
                      <label for="parent_id" class="form-label fw-semibold"><i class="text-danger"> * </i>Parent</label>
                      <select id="parent_id" name="parent_id" class="form-control select2">
                          <option value="">Select Parent</option>
                          <option value="{{ $student->parent_id }}" selected>{{ $student->parent->name }}</option>
                      </select>
                      @error('parent_id')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-4">
                      <label for="school" class="form-label fw-semibold"><i class="text-danger"> * </i>School</label>
                      <input type="text" name="school" value="{{$student->school}}" class="form-control" id="school">
                      @error('school')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                    <div class="mb-4">
                        <label for="no_of_classes" class="form-label fw-semibold"><i class="text-danger"> * </i>Total Classes</label>
                        <input type="text" name="no_of_classes" value="{{$student->no_of_classes}}" class="form-control" id="no_of_classes" readonly>
                        @error('no_of_classes')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                  <div class="mb-4">
                    <label for="class_id" class="form-label fw-semibold"><i class="text-danger"> * </i>Class</label>
                    <select id="class_id" name="class_id" class="form-control select2">
                        <option value="" disabled>Select Class</option>
                        @foreach($classes as $class)
                          <option value="{{ $class->id }}" {{ $student->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-5">
                  <div class="mb-4">
                    <label for="due_date" class="form-label fw-semibold"><i class="text-danger">*</i>Due Date</label>
                    <input type="date" name="due_date" value="{{$student->due_date}}" class="form-control" id="due_date">
                    @error('due_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-5">
                    <div class="mb-4">
                      <label for="class_start_date" class="form-label fw-semibold"><i class="text-danger">*</i>Start Date</label>
                      <input type="date" name="class_start_date" value="{{$student->class_start_date}}" class="form-control" id="class_start_date">
                      @error('class_start_date')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                </div>
                <div class="col-lg-2">
                  <div class="mt-2 form-check form-switch d-flex flex-column align-items-center">
                    <label class="form-label fw-semibold" for="due_grace">Due Grace Enable</label>
                    <input class="form-check-input" type="checkbox" id="due_grace" name="due_grace" value="1" {{$student->due_grace == 1 ? 'checked' : ''}}>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-5">
                    <div class="mb-4">
                        <label for="payable_amount" class="form-label fw-semibold"><i class="text-danger"> * </i> Payable Amount</label>
                        <input type="number" name="payable_amount" value="{{$student->payable_amount}}" class="form-control" id="payable_amount">
                        @error('payable_amount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="mb-4">
                        <label for="payment_status" class="form-label fw-semibold"><i class="text-danger"> * </i>Payment Status</label>
                        <select id="payment_status" name="payment_status" class="form-control select2">
                            <option value="Pending" {{ $student->payment_status == 'Pending'? 'selected':''}}>Pending</option>
                            <option value="Paid" {{ $student->payment_status == 'Paid'? 'selected':''}}>Paid</option>
                        </select>
                        @error('payment_status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-2">
                  <div class="mt-2 form-check form-switch d-flex flex-column align-items-center">
                    <label for="active_payment" class="form-label fw-semibold">Payment Active</label>
                    <input type="checkbox" class="form-check-input" name="active_payment" id="active_payment" {{$student->active_payment == 1 ? 'checked' : ''}} >
                  </div>  
                </div>
              </div>
              <div class="row">
                <div class="col-lg-4">
                  <div class="mb-4">
                    <label for="due_installments" class="form-label fw-semibold"><i class="text-danger">*</i> Due Installments</label>
                    <input type="number" name="due_installments" value="{{$student->due_installments }}" class="form-control" id="due_installments">
                    @error('due_installments')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-4">
                    <label for="age" class="form-label fw-semibold"><i class="text-danger"> * </i> Age</label>
                    <input type="number" name="age" value="{{$student->age}}" class="form-control" id="age">
                    @error('age')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="mb-4">
                    <label for="due_for_months" class="form-label fw-semibold"><i class="text-danger">*</i> Due Months</label>
                    <select id="due_for_months" name="due_for_months[]" class="form-control select2" multiple>
                      <option value=""></option>
                      @foreach($months as $month)
                        @if(is_null($student->due_for_months))
                          <option value="{{ $month }}">{{ $month }}</option>
                        @else
                          <option value="{{ $month }}"{{in_array($month, explode("," , $student->due_for_months)) ? 'selected' : ''}} >{{ $month }}</option>
                        @endif
                      @endforeach
                    </select>
                    @error('due_for_months')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                    <label for="students_note" class="form-label fw-semibold">Notes</label>
                    <textarea class="form-control" name="students_note" id="students_note" rows="2"></textarea>
                </div>
              </div>
              <input type="hidden" name="action" id="action" value="-1">
              {{-- Start modal for readmitted students --}}
              <div id="readmit-modal" class="modal fade" tabindex="-1" aria-labelledby="primary-header-modalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content text-center">
                    <div class=" modal-colored-header bg-primary p-2">
                      <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="col-lg-12">
                        <div class="mb-4 text-start">
                          <label for="user_id" class="form-label fw-semibold"><i class="text-danger"> * </i>Admitted By</label>
                          <select id="user_id" name="user_id" class="form-control select" onchange="$('#user_id_error').hide();">
                              <option value=""> Select User </option>
                              @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                              @endforeach
                          </select>
                          <div id="user_id_error" class="text-danger" style="display:none;">Please Select Admitted By</div>
                        </div>
                      </div>
                      <div class="text-end">
                        <button type="button" class="btn btn-primary float-end ms-1 fs-4 font-medium" onclick="submitFormWithExecutive()">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{-- End modal for readmitted students --}}
            </form>
          </div>
        </div>
        <div class="card mt-3 ps-3 pt-3 pe-3 pb-2">
          <div class="">
              <a class="btn btn-light float-start" href="/students">Back</a>
                <div class="button-group">
                  @if($usr->can('student.update'))
                    <button class="btn btn-primary float-end ms-1 px-4 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(-1)">Update</button>
                  @endif
                  @if($student->status == 1)
                    @if($usr->can('student.graduate'))
                      <button class="btn btn-success float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(2)">Graduated</button>
                    @endif
                    @if($usr->can('student.terminate'))
                      <button class="btn btn-danger float-end ms-1 px-4 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(0)">Terminate</button>
                    @endif
                    @if($usr->can('student.on_hold'))
                      <button class="btn btn-danger float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(3)">On Hold</button>
                    @endif
                    @if($usr->can('student.delete'))
                      <button class="btn btn-danger float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(4)">Delete</button>
                    @endif
                  @elseif($student->status == 2)
                    @if($usr->can('student.re_admit'))
                      <button class="btn btn-primary float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#readmit-modal" onclick="showModalBeforeSubmission(1)">Re-Admit</button>
                    @endif
                    @if($usr->can('student.terminate')) 
                      <button class="btn btn-danger float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(0)">Terminate</button>
                    @endif
                    @if($usr->can('student.on_hold'))
                      <button class="btn btn-danger float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(3)">On Hold</button>
                    @endif
                    @if($usr->can('student.delete'))
                      <button class="btn btn-danger float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(4)">Delete</button>
                    @endif
                  @elseif($student->status == 3)
                    @if($usr->can('student.re_admit'))
                      <button class="btn btn-primary float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#readmit-modal" onclick="showModalBeforeSubmission(1)">Re-Admit</button>
                    @endif
                    @if($usr->can('student.graduate'))
                      <button class="btn btn-success float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(2)">Graduated</button>
                    @endif
                    @if($usr->can('student.terminate'))
                      <button class="btn btn-danger float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(0)">Terminate</button>
                    @endif
                    @if($usr->can('student.delete'))
                      <button class="btn btn-danger float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(4)">Delete</button>
                    @endif
                  @else
                  @if($usr->can('student.re_admit'))
                  <button class="btn btn-primary float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#readmit-modal" onclick="showModalBeforeSubmission(1)">Re-Admit</button>
                  @endif
                    @if($usr->can('student.delete'))
                      <button class="btn btn-danger float-end ms-1 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#primary-header-modal" onclick="showModalBeforeSubmission(4)">Delete</button>
                    @endif
                  @endif
                  <div id="primary-header-modal" class="modal fade" tabindex="-1" aria-labelledby="primary-header-modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content text-center">
                        <div class=" modal-colored-header p-2">
                          <h4 class="modal-title" id="primary-header-modalLabel">
                            Are You Sure ? <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                          </h4>
                        </div>
                        <div class="modal-body">
                          <p id="modal_text" class="font-medium text-bold"></p>
                          <button type="button" class="btn btn-light-success text-success me-3" data-bs-dismiss="modal">No</button>
                          <button type="button" class="btn btn-light-danger text-danger font-medium ms-3" onclick="submitForm()">Yes</button>
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
<script src="{{ asset('assets/modernize/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/modernize/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/modernize/js/forms/select2.init.js') }}"></script>