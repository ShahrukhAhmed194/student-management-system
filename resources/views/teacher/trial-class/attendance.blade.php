<x-dashboard.teacher-layout>
    <x-slot name='title'>Trial Class Attendance - Dreamers Academy</x-slot>
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                            <div class="col-9">
                                <h4 class="fw-semibold mb-8">Trial Class Attendance</h4>
                                <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="text-muted" href="/">Home</a></li>
                                    <li class="breadcrumb-item" aria-current="page">Add Attendance</li>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 pb-3 border-bottom">
                                <h5 class="card-title fw-semibold mb-0">Attendance Form</h5>
                            </div>
                            <table class="table  table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">#</th>
                                        <th scope="col" >Name</th>
                                        <th scope="col" class="text-center">Present</th>
                                        <th scope="col" class="text-center">Joined</th>
                                        <th scope="col" class="text-center">Feedback</th>
                                    </tr>
                                </thead>
                                </tbody> @php $index = 0; @endphp
                                <form action="/submit-attendance" method="post">
                                    @csrf
                                    @foreach($trial_classes as $trial_class)
                                        <tr class="attendanceBox">
                                            <input type="hidden" name="link_id" value="{{$trial_class->trial_class_id}}">
                                            <input type="hidden" name="ids[]" value="{{$trial_class->id}}">
                                            <td class="text-center">{{$index+1}}</td>
                                            <td > {{ $trial_class->student_name }}</td>
                                            <td class="text-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input secondary present" type="checkbox" name="status[{{$index}}]" value="Attended" {{$trial_class->status == 'Attended'? 'checked' : ''}} />
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input secondary joined" type="checkbox" name="is_joined[{{$index}}]" value="Joined" {{$trial_class->status == 'Joined'? 'checked' : ''}} />
                                                </div>
                                            </td>
                                            <td class="form-group">
                                                <textarea class="form-control" name="feed_back[]" rows="2" cols="50">{{$trial_class->feed_back == null ? '': $trial_class->feed_back}}</textarea>
                                            </td>
                                        </tr>
                                        @php $index ++; @endphp
                                    @endforeach
                                    <!-- End Table with stripped rows -->
                                </tbody>
                            </table>
                            <div class="m-3">
                                <div class="col-12">
                                    <div class=" align-items-center justify-content-end mt-4 gap-3">
                                      <a class="btn btn-light" href="/trial-class-list">Back</a>
                                      <button type="submit" class="btn btn-primary float-end">Save</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/teacher/trial-class/attendance-1.0.0.js')}}"></script>
</x-dashboard.teacher-layout>