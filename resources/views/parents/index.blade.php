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
                                <li class="breadcrumb-item" aria-current="page">All Parents</li>
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
                        @if (Auth::guard('web')->user()->can('parents.add'))
                            <a href="/parents/create" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
                            <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add New</span>
                            </a>
                        @endif
                    </div>
                    <div class="card-body table-responsive overflow-auto">
                        <!-- Table with stripped rows -->
                        <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'parents-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Occupation</th>
                                    <th scope="col">Religion</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parents as $parent)
                                <tr>
                                    <th scope="row">{{ $parent->id }}</th>
                                    <td>
                                        <a @if (Auth::guard('web')->user()->can('parents.edit')) href="/parents/{{$parent->id}}/edit" @endif>
                                            {{ $parent->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $parent->user->email }}</td>
                                    <td>{{ $parent->gender }}</td>
                                    <td>{{ $parent->phone }}</td>
                                    <td>{{ $parent->occupation }}</td>
                                    <td>{{ $parent->religion }}</td>
                                    <td>{{ $parent->country }}</td>
                                    <td>{{ $parent->address }}</td>
                                    
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
    <script src="{{asset('assets/js/parent/print-file-1.0.0.js')}}"></script>
</x-dashboard.admin-layout>