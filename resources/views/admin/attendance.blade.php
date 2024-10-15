<x-dashboard.admin-layout>
  <x-slot name='title'>Attendance Report - Dreamers Academy</x-slot>
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
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
                                <li class="breadcrumb-item" aria-current="page">Attendance Report</li>
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
                        <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse_search"
                        aria-expanded="false"
                        aria-controls="collapse_search"
                        >
                        Search Here
                        </button>
                    </h2>
                    <div id="collapse_search" class="accordion-collapse collapse" aria-labelledby="accordion_search" data-bs-parent="#accordion_filter">
                        <div class="accordion-body h-auto">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="class_id" class="form-label col-md-12">Class Name</label>
                                    <select id="class_id" name="class_id" class="form-select col-md-12 select2">
                                        <option selected value="" disabled>Choose...</option>
                                        @foreach($classes as $classe)
                                            <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="select-student" class="form-label fw-semibold col-md-12">Student Name</label>
                                    <select id="select-student" name="select-student" class="form-select col-md-12 select2">
                                        <option selected value="" disabled>Choose...</option>
                                        <?php 
                                            
foreach($students as $student){
       $status = '';	
                                            	if($student->status != 1){
                                                	$status = ' (Inactive) ';
                                            	}
                                            ?>
                                            <option value="<?php echo $student->user_id; ?>"><?php echo $student->name. $status ?> </option>
					    <?php 
					    }
					 ?>
                                    </select>
                                    @error('select-student')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label for="from_date" class="form-label">Start Date</label>
                                    <input type="date" id="from_date" name="from_date" class="form-control" value="{{old('from_date')}}">
                                </div>
                                <div class="col-md-2">
                                    <label for="to_date" class="form-label">End Date</label>
                                    <input type="date" id="to_date" name="to_date" class="form-control" value="{{old('to_date')}}">
                                </div>
                                <div class="col-md-2">
                                    <button  class="btn btn-outline-primary" style="margin-top: 30px" onclick="attendance_details()">Generate</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="{{ (Auth::guard('web')->user()->can('report.download') == 1) ? 'attendance-rpt-datatable' : 'basic-datatable' }}" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
  <script src="{{asset('assets/js/admin/attendance-2.1.1.js')}}"></script>
</x-dashboard.admin-layout>
