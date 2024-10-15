<x-dashboard.admin-layout>
    <x-slot name='title'>Class Schedules - Dreamers Academy</x-slot>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-xxl-n4">
                <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                    <div class="card-body px-4 py-3">
                    <div class="row align-items-center">
                        <div class="col-9">
                        <h4 class="fw-semibold mb-8">Class Schedule</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Edit Class Schedule</li>
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
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12"></div>
            <div class="col-xl-6 col-lg-6 col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 py-2 border-bottom">
                            <h5 class="card-title fw-semibold mb-0">Class Schedule Form</h5>
                        </div>
                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{ route('class-schedule.update', $class_schedule->id) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="class_id" class="form-label">Class</label>
                                <select id="class_id" name="class_id" class="form-select choices" required>
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $class_schedule->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="day" class="form-label">Day</label>
                                <select id="day" name="day" class="form-select choices">
                                    <option value="">Select day</option>
                                    <option value="Saturday" {{ $class_schedule->day == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                    <option value="Sunday" {{ $class_schedule->day == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                    <option value="Monday" {{ $class_schedule->day == 'Monday' ? 'selected' : '' }}>Monday</option>
                                    <option value="Tuesday" {{ $class_schedule->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                    <option value="Wednesday" {{ $class_schedule->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                    <option value="Thursday" {{ $class_schedule->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                    <option value="Friday" {{ $class_schedule->day == 'Friday' ? 'selected' : '' }}>Friday</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="time" class="form-label">Time</label>
                                <input type="time" name="time" value="{{ $class_schedule->time }}" class="form-control" id="time">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12"></div>
        </div>
    </div>


</x-dashboard.admin-layout>