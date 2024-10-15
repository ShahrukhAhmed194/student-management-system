@if(count($trial_class_schedules) > 0)
    <!-- Table with stripped rows -->
    <table data-order='[[ {{ $condition == 'today' ? 3 : 1 }}, "asc" ]]' id="basic-datatable" class="table border table-striped table-bordered display text-nowrap">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Track</th>
                <th scope="col">Time</th>
                <th scope="col">Students</th>
                @role('Admin|Super-Admin')
                <th scope="col">Action</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach($trial_class_schedules as $trial_class_schedule)
                <tr>
                    <th scope="row">{{ $trial_class_schedule->id }}</th>
                    <td>{{ date('d M, Y', strtotime($trial_class_schedule->date)) }}</td>
                    <td>
                        @if($trial_class_schedule->age_from == 7 && $trial_class_schedule->age_to == 8)
                            Track#1
                        @elseif($trial_class_schedule->age_from == 9 && $trial_class_schedule->age_to == 10)
                            Track#2
                        @elseif($trial_class_schedule->age_from >= 11 && $trial_class_schedule->age_to <= 14)
                            Track#3
                        @else
                            Inaccurate Age Range
                        @endif
                    </td>
                    <td>{{ date('h:i A', strtotime($trial_class_schedule->time)) }}</td>
                    <td>
                        <a @if(can('attendance.add')) href="/trial-class/attendance/{{$trial_class_schedule->id}}" @endif class="btn btn-outline-primary">
                            {{DB::table('trial_classes')->where('trial_class_id',$trial_class_schedule->id)->where('status','!=', 'Invalid')->where('status','!=', 'Wants to Reschedule')->count()}}
                        </a>
                    </td>
                    @role('Admin|Super-Admin')
                    <td>
                        <a href="/trial-class/{{$trial_class_schedule->id}}/edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                    @endrole
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
@else
    <div class="alert alert-danger text-center" role="alert">
        No trial class schedule found!
    </div>
@endif

<script src="{{ asset('assets/modernize/js/datatable/datatable-advanced.init.js') }}"></script>
