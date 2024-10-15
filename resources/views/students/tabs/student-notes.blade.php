<div class="row">
  <div class="col-md-12">
    <div class="card mb-0">
      <div class="px-4 py-3 border-bottom">
        <h5 class="card-title fw-semibold mb-0 lh-sm">Student's Notes</h5>
      </div>
      <div class="card-body table-responsive overflow-auto">
        <table id="basic-datatable" class="table border table-striped table-bordered display">
          <thead>
              <tr>
                  <th scope="col">#</th>
                  <th width="33%" >Note</th>
                  <th scope="col">Submitted By</th>
                  <th scope="col">Date</th>
                  <th scope="col">Time</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($note_histories as $index => $note_history)
                  <tr>
                      <td>{{++$index}}</td>
                      <td>{{$note_history->note}}</td>
                      <td>{{$note_history->stenographer->name}}</td>
                      <td>{{date('M d, Y', strtotime($note_history->created_at. ' + 6 hours'))}}</td>
                      <td>{{date('h:i A', strtotime($note_history->created_at. ' + 6 hours'))}}</td>
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