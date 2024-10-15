<x-dashboard.admin-layout>
    <x-slot name='title'>All Parents - Dreamers Academy</x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                      <div class="row align-items-center">
                        <div class="col-9">
                          <h4 class="fw-semibold mb-8">Parents</h4>
                          <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                              <li class="breadcrumb-item" aria-current="page">Update Parent</li>
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
                    <form class="row g-3" action="{{ route('parents.update', $parent->id) }}" method="POST">
                        @csrf @method('PUT')
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold"><i class="text-danger"> * </i> Name</label>
                                <input type="text" name="name" value="{{ $parent->user->name }}" class="form-control" id="name">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                              <label for="user_name" class="form-label fw-semibold"><i class="text-danger">* </i>User Name</label>
                              <input type="text" name="user_name" value="{{$parent->user->user_name}}" class="form-control" id="user_name">
                              @error('user_name')
                                  <div class="text-danger ">{{ $message }}</div>
                              @enderror
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="phone" class="form-label fw-semibold"><i class="text-danger"> * </i> Phone</label>
                                <input type="text" name="phone" value="{{ $parent->phone }}" class="form-control" id="phone">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
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
                              </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold"><i class="text-danger">* </i>Emal</label>
                                <input type="text" name="email" value="{{ $parent->user->email }}" class="form-control" id="email">
                                @error('email')
                                    <div class="text-danger ">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="occupation" class="form-label fw-semibold"><i class="text-danger"> * </i>Occupation</label>
                                <input type="text" name="occupation" value="{{ $parent->occupation }}" class="form-control" id="occupation">
                                @error('occupation')
                                    <div class="text-danger">{{ $message }}</div>
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
                                  <option value="Parent" selected>Parent</option>
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
                                  <option value="">Choose...</option>
                                  <option value="Male" {{ $parent->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                  <option value="Female" {{ $parent->gender == 'Female' ? 'selected' : '' }}>Female</option>
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
                              <label for="country" class="form-label fw-semibold"><i class="text-danger"> * </i>Country</label>
                              <select id="country" name="country" class="form-control select2">
                                <option value="" selected="" disabled="">Choose... </option>
                                @for($i=0; $i<count($countries); $i++)
                                <option value="{{$countries[$i]}}" {{$parent->country == $countries[$i] ? 'selected':''}}>{{$countries[$i]}}</option>
                                @endfor
                              </select>
                              @error('country')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                              <label for="religion" class="form-label fw-semibold"><i class="text-danger"> * </i>Religion</label>
                              <select id="religion" name="religion" value="{{old('religion')}}" class="form-control select2">
                                <option value="" selected="" disabled="">
                                    Choose...
                                </option>
                                @for($i=0; $i<count($religions); $i++)
                                <option value="{{$religions[$i]}}" {{$parent->religion == $religions[$i] ? 'selected':''}}>
                                    {{$religions[$i]}}
                                </option>
                                @endfor
                              </select>
                              @error('religion')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <input type="text" name="address" value="{{$parent->address}}" class="form-control" id="address">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                            <div class=" align-items-center justify-content-end mt-4 gap-3">
                              <a class="btn btn-light" href="/parents">Back</a>
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