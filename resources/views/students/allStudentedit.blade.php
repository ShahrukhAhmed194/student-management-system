<x-dashboard.admin-layout>
    <x-slot name='title'>All Students - Dreamers Academy</x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                        <div class="row align-items-center">
                        <div class="col-9">
                            <h4 class="fw-semibold mb-8">Students Edit</h4>
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card pt-2">
                    <div class="card-body">
                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="/allstudents-update/{{ $allresults['student']->id }}" method="POST" id="update_student">
                            @csrf @method('PUT')
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="{{$allresults['student']->name}}" class="form-control" id="name" >
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" value="{{$allresults['student']->email}}" class="form-control" id="email" >
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <span style="color:#e41111">*</span>
                                <label for="user_name" class="form-label">User Name</label>
                                <input type="text" name="user_name" value="{{$allresults['student']->user_name}}" class="form-control" id="user_name" >
                                @error('user_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" >
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class=" align-items-center justify-content-end mt-4 gap-3">
                        <a class="btn btn-light" href="/allstudents">Back</a>
                        <button class="btn btn-primary float-end">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.admin-layout>