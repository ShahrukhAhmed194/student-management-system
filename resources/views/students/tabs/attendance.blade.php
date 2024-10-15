<div class="row">
    <div class="col-12">
        <div class="card mb-0">
            <div class="px-4 py-3 border-bottom">
                <h5 class="card-title fw-semibold mb-0 lh-sm">Attendance History</h5>
            </div>
            <div class="card-body table-responsive overflow-auto">
                <table id="basic-datatable" class="table border table-striped table-bordered display table-responsive">
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
                        @foreach ($attendances as $index => $attendance)
                            <tr>
                                <td>{{++$index}}</td>
                                <td>{{$attendance->name}}</td>
                                <td>{{$attendance->date}}</td>
                                <td>{{$attendance->status == 1 ? 'Present' : 'Absent'}}</td>
                                <td>{{$attendance->comments}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card  mt-3">
            <div class="card-body p-3">
                <a class="btn btn-light float-start" href="/students">Back</a>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/modernize/js/datatable/datatable-advanced.init.js') }}"></script>