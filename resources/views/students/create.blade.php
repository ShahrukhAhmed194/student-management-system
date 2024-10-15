<x-dashboard.admin-layout>
    <x-slot name='title'>New Student - Dreamers Academy</x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">New Student</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Add Student</li>
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
            <div class="col-md-12">
                <div class="card w-100 position-relative overflow-hidden mb-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold  mb-3">New Student Form</h5>
                    <form action="{{ route('students.store') }}" method="POST">
                      @csrf
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="name" class="form-label fw-semibold"><i class="text-danger"> * </i> Name</label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="user_name" class="form-label fw-semibold"><i class="text-danger">* </i>User Name</label>
                            <input type="text" name="user_name" value="{{old('user_name')}}" class="form-control" id="user_name">
                            @error('user_name')
                                <div class="text-danger ">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="email" class="form-label fw-semibold"><i class="text-danger">* </i>Email</label>
                            <input type="text" name="email" value="{{old('email')}}" class="form-control" id="email">
                            @error('email')
                                <div class="text-danger ">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold"><i class="text-danger">* </i>Password</label>
                                <input type="password" name="password" value="{{old('password')}}" class="form-control" id="password">
                                @error('password')
                                    <div class="text-danger ">{{ $message }}</div>
                                @enderror
                              </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                              <label for="user_type" class="form-label fw-semibold"><i class="text-danger"> * </i>User Type</label>
                              <select id="user_type" name="user_type" value="{{old('user_type')}}" class="form-control select2">
                                  <option value="">Select User Type</option>
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
                              <select id="gender" name="gender" title="gender" value="{{old('gender')}}" class="form-control select2">
                                  <option value="">Select Gender</option>
                                  <option value="Male">Male</option>
                                  <option value="Female">Female</option>
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
                              <select id="parent_id" name="parent_id" value="{{old('parent_id')}}" class="form-control select2">
                                  <option value="">Select Parent</option>
                                  @foreach($parents as $parent)
                                    <option value="{{ $parent->user->id }}">{{ $parent->user->name }}</option>
                                  @endforeach
                              </select>
                              @error('parent_id')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                              <label for="class_id" class="form-label fw-semibold"><i class="text-danger"> * </i>Class</label>
                              <select id="class_id" name="class_id" value="{{old('class_id')}}" class="form-control select2">
                                  <option value="">Select Class</option>
                                  @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                  @endforeach
                              </select>
                              @error('class_id')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="school" class="form-label fw-semibold"><i class="text-danger"> * </i>School</label>
                                <input type="text" name="school" value="{{old('school')}}" class="form-control" id="school">
                                @error('school')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="mb-4">
                            <label for="age" class="form-label fw-semibold"><i class="text-danger"> * </i> Age</label>
                            <input type="number" name="age" value="{{old('age')}}" class="form-control" id="age">
                            @error('age')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-12">
                          <div class=" align-items-center justify-content-end mt-4 gap-3">
                            <a class="btn btn-light" href="/students">Back</a>
                            <button class="btn btn-primary float-end">Save</button>
                          </div>
                      </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin-layout>