@php
    use App\Models\User;
@endphp
<x-dashboard.admin-layout>
    <x-slot name='title'>All Users - Dreamers Academy</x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                        <div class="row align-items-center">
                        <div class="col-9">
                            <h4 class="fw-semibold mb-8">Users</h4>
                            <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                <li class="breadcrumb-item" aria-current="page">Update User</li>
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
                        <h5 class="card-title fw-semibold  mb-3">User Update Form</h5>
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $user->id }}" id="id">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold"><i class="text-danger"> * </i> Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold"><i class="text-danger">* </i>Emal</label>
                                    <input type="text" name="email" value="{{$user->email}}" class="form-control" id="email">
                                    @error('email')
                                        <div class="text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="user_name" class="form-label fw-semibold"><i class="text-danger"> * </i> User Name</label>
                                    <input type="text" name="user_name" value="{{ $user->user_name }}" class="form-control" id="user_name">
                                    @error('user_name')
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
                                    <label for="user_type" class="form-label fw-semibold"><i class="text-danger"> * </i>User Type</label>
                                    <select id="user_type" name="user_type" onchange="showDiv()" value="{{old('user_type')}}" class="form-control select2">
                                    <option selected value="" disabled>Choose...</option>
                                    <option value="{{ User::USER_TYPE_STUDENT }}" {{$user->user_type == User::USER_TYPE_STUDENT ? 'selected' : ''}}>{{ User::USER_TYPE_STUDENT }}</option>
                                    <option value="{{ User::USER_TYPE_PARENT }}" {{$user->user_type == User::USER_TYPE_PARENT ? 'selected' : ''}}>{{ User::USER_TYPE_PARENT }}</option>
                                    <option value="{{ User::USER_TYPE_TEACHER }}" {{$user->user_type == User::USER_TYPE_TEACHER ? 'selected' : ''}}>{{ User::USER_TYPE_TEACHER }}</option>
                                    <option value="{{ User::USER_TYPE_COORDINATOR }}" {{$user->user_type == User::USER_TYPE_COORDINATOR ? 'selected' : ''}}>{{ User::USER_TYPE_COORDINATOR }}</option>
                                    <option value="{{ User::USER_TYPE_ADMIN }}" {{$user->user_type == User::USER_TYPE_ADMIN ? 'selected' : ''}}>{{ User::USER_TYPE_ADMIN }}</option>
                                    <option value="{{ User::USER_TYPE_SUPER_ADMIN }}" {{$user->user_type == User::USER_TYPE_SUPER_ADMIN ? 'selected' : ''}}>Super Admin</option>
                                    <option value="{{ User::USER_TYPE_SALES_EXECUTIVE }}" {{$user->user_type == User::USER_TYPE_SALES_EXECUTIVE ? 'selected' : ''}}>{{ User::USER_TYPE_SALES_EXECUTIVE }}</option>
                                    <option value="{{ User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE }}" {{$user->user_type == User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE ? 'selected' : ''}}>{{ User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE }}</option>
                                    </select>
                                    @error('user_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="phone" class="form-label fw-semibold"> Phone Number</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" class="form-control" id="phone" maxlength="14" minlength="11">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4" id="zoom_link_div">
                                    <label for="value_a" class="form-label fw-semibold"><i class="text-danger">* </i>Zoom Link</label>
                                    <input type="value_a" name="value_a" value="{{ $user->value_a }}" class="form-control" id="value_a">
                                    @error('value_a')
                                        <div class="text-danger ">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4" id="zoom_topic_div">
                                    <label for="zoom_topic" class="form-label fw-semibold"><i class="text-danger"> * </i> Zoom Topic</label>
                                    <input type="text" name="zoom_topic" value="{{ $user->zoom_topic }}" class="form-control" id="zoom_topic">
                                    @error('zoom_topic')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4" id="zoom_meeting_id_div">
                                    <label for="zoom_meeting_id" class="form-label fw-semibold"><i class="text-danger"> * </i>Zoom Meeting ID</label>
                                    <input type="text" name="zoom_meeting_id" value="{{ $user->zoom_meeting_id }}" class="form-control" id="zoom_meeting_id">
                                    @error('zoom_meeting_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4" id="zoom_password_div">
                                    <label for="zoom_password" class="form-label fw-semibold"><i class="text-danger"> * </i> Zoom Password</label>
                                    <input type="text" name="zoom_password" value="{{ $user->zoom_password }}" class="form-control" id="zoom_password">
                                    @error('zoom_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $track_ids = array();
                            if($user->track_ids !=null){
                                $track_ids = (json_decode($user->track_ids));
                            }
                            ?>
                            <div class="col-lg-6">
                                <div class="mb-4" id="course_div">
                                    <label for="course_id" class="form-label fw-semibold"><i class="text-danger"> * </i>Course</label>
                                    <select id="course_id" name="course_id" value="" class="form-control select2" onchange="courseWisetrack()">
                                    <option value="">Choose...</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ (@$getCourseInfoByTrack->id == $course->id) ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                    @endforeach
                                    </select>
                                    @error('course_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4" id="track_div">
                                    <label for="track_ids" class="form-label fw-semibold"><i class="text-danger"> * </i>Track Info</label>
                                    <select id="track_ids" name="track_ids[]" value="" class="form-control select2" multiple>
                                    <option value="" disabled>Choose...</option>
                                    @foreach($tracks as $track)
                                    <option value="{{ $track->id }}" <?php if (in_array($track->id, $track_ids)){ echo 'selected'; } ?> >{{ $track->track_num }}</option>
                                    @endforeach
                                    </select>
                                    @error('user_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-4" id="class_login_details_div">
                                    <label for="class_login_details" class="form-label fw-semibold"><i class="text-danger"> * </i>Class Login Details</label>
                                    <textarea name="class_login_details" class="form-control" id="class_login_details" placeholder="Class Login Details">{{ $user->class_login_details }}</textarea>
                                    @error('class_login_details')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class=" align-items-center mt-4 gap-3">
                                    <a class="btn btn-light" href="/parents">Back</a>
                                    <input type="hidden" name="status" id="status" value="{{$user->status}}">
                                    <button type="submit" class="btn btn-primary float-end ms-1">Save</button>
                                    @if ($user->status == 0)
                                    <button type="submit" class="btn btn-success float-end ms-1" id="active">Active</button>
                                    @else
                                    <button type="submit" class="btn btn-danger float-end ms-1" id="inactive">Inactive</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/users/teacher-information-1.2.2.js')}}"></script>
</x-dashboard.admin-layout>
