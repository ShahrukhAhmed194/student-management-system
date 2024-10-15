
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
                                <li class="breadcrumb-item" aria-current="page">All Users</li>
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
            <div class="col-12">
                <div class="card ">
                    <div class="">
                        @if (Auth::guard('web')->user()->can('users.add'))
                            <a href="/users/create" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
                            <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add New</span>
                            </a>
                        @endif
                    </div>
                    <div class="card-body table-responsive overflow-auto">
                        <!-- Table with stripped rows -->
                        <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'all-users-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">User Type</th>
                                    <th scope="col">Class Login Details</th>
                                    <th scope="col">Zoom Link</th>
                                    <th scope="col">Zoom Topic</th>
                                    <th scope="col">Zoom Meeting ID</th>
                                    <th scope="col">Zoom Password</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>
                                        <a @if (Auth::guard('web')->user()->can('users.edit')) href="/users/{{$user->id}}/edit" @endif>
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->user_name }}</td>
                                    <td>{{ $user->user_type }}</td>
                                    <td>{{ $user->class_login_details }}</td>
                                    <td>{{ $user->value_a }}</td>
                                    <td>{{ $user->zoom_topic }}</td>
                                    <td>{{ $user->zoom_meeting_id }}</td>
                                    <td>{{ $user->zoom_password }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/users/print-file-1.0.0.js')}}"></script>

</x-dashboard.admin-layout>