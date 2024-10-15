<div class="row">
  <div class="col-md-12">
    <div class="card mb-0">
      <div class="px-4 py-3 border-bottom">
        <h5 class="card-title fw-semibold mb-0 lh-sm">Coding Program Roadmap</h5>
      </div>
      <div class="card-body table-responsive overflow-auto">
        <table id="basic-datatable" class="table border table-striped table-bordered display table-responsive">
          <thead>
              <tr>
                  <th scope="col">#</th>
                  <th width="33%" >Track</th>
                  <th scope="col">Level</th>
                  <th scope="col" class="text-center">Status</th>
                  <th scope="col" class="text-center">Start Date</th>
                  <th scope="col" class="text-center">Completion Date</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($getTrackLevels as $index => $info)
              @php
                $getStudentTrackLevelInfo = App\Models\StudentTrackLevel::where('student_id', $student->id)
                            ->where('track_id', $info->track_id)
                            ->where('level_id', $info->id)
                            ->first();
                
                $start_date = (!empty($getStudentTrackLevelInfo->start_date) ? $getStudentTrackLevelInfo->start_date : '');
                $completion_date = (!empty($getStudentTrackLevelInfo->completion_date) ? $getStudentTrackLevelInfo->completion_date : '');

                
                if($start_date && $completion_date){
                  $getStuentTrackLevelAttendances = App\Models\StudentAttendance::where('student_id', $student->user->id)
                                                      ->whereBetween('date', [$start_date, $completion_date])
                                                      ->count();
                }elseif($start_date){
                  $getStuentTrackLevelAttendances = App\Models\StudentAttendance::where('student_id', $student->user->id)
                                                      ->where('date', '>=', $start_date)
                                                      ->count();
                }else{
                  $getStuentTrackLevelAttendances = 0;
                }

              @endphp
                  <tr>
                      <td>{{++$index}}</td>
                      <td>Track {{ $info->track_num }}</td>
                      <td>Level {{ $info->level_num }}</td>
                      <td class="text-center">
                        {{ $getStuentTrackLevelAttendances.'/'. (!empty($info->duration) ? $info->duration : 0) }}
                      </td>
                      <td class="text-center">
                        <input type="date" id="start_date_{{++$index}}" value="{{ (!empty($start_date) ? $start_date : '') }}" class="form-control" onchange="roadMapDataSave(this.value, '', '{{ $student->id }}', '{{ $info->track_id }}', '{{ $info->id }}')">
                      </td>
                      <td class="text-center">
                        <input type="date" id="completion_date_{{++$index}}" value="{{ (!empty($completion_date) ? $completion_date : '') }}" class="form-control" onchange="roadMapDataSave('', this.value, '{{ $student->id }}', '{{ $info->track_id }}', '{{ $info->id }}')">
                      </td>
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
