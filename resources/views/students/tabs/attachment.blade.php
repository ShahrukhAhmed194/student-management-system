<div class="row">
    <div class="col-md-12">
      <div class="card mt-4">
        <div class="px-4 py-3 border-bottom">
          <div class="d-flex justify-content-between my-3 mx-2">
            <h5 class="card-title fw-semibold mb-0 lh-sm">Student's Attachment</h5>
            <button class="btn me-1 mb-1 btn-primary text-white btn-lg fs-4 font-medium"
            data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md"><i class="ti ti-plus me-0 me-md-1 fs-4"></i>  Add New</button>
          </div>
        </div>
        
          <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form action="{{ route('attachment-save') }}" method="post" enctype="multipart/form-data">
                    @csrf
                  <div class="modal-header d-flex align-items-center border-bottom" >
                    <h4 class="modal-title" id="myModalLabel">
                      Upload Attachment
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="form-group mb-4 row">
                          <label for="attachment" class="col-sm-3 col-form-label text-right"> Attachment <i class="text-danger"> *</i></label>
                          <div class="col-sm-9">
                              <input name="attachment" class="form-control" type="file" placeholder="" id="attachment" onchange="attachmentValidation(this,'attachment')" accept=".png, .jpg, .jpeg, .gif, .bmp, .web" required>
                              <span class="text-danger">.png, .jpg, .jpeg, .gif, .bmp, .web only supported</span>
                          </div>
                      </div>
                      <div class="form-group mb-4 row">
                          <label for="notes" class="col-sm-3 col-form-label text-right"> Notes <i class="text-danger"> *</i></label>
                          <div class="col-sm-9">
                              <textarea name="notes" class="form-control" rows="5" placeholder="" id="notes" required></textarea>
                          </div>
                      </div>
                  </div>
                  <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                  <input type="hidden" name="student_id" id="student_id" value="{{ $studentId }}">
                  <div class="modal-footer justify-content-between border-top">
                      &nbsp;
                      <button type="submit" class="btn btn-primary btn-sm">Save</button>
                  </div>
                </form>
                </div>
              </div>
          </div>

          <div class="card-body">
              <table id="basic-datatable" class="table border table-striped table-bordered display">
                  <thead>
                      <tr>
                          <th scope="col" width="5%">#</th>
                          <th scope="col" width="15%" class="text-center">Attachment</th>
                          <th scope="col" width="35%">Note</th>
                          <th scope="col" width="15%">Attached By</th>
                          <th scope="col" width="20%">Date & Time</th>
                          <th scope="col" width="10%" class="text-center">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if($attachmentHistories)
                      @foreach ($attachmentHistories as $index => $attachment)
                          <tr>
                              <td>{{++$index}}</td>
                              <td class="text-center">
                                <a class="" href="javascript:void(0)" onclick="attachmentShow({{ $attachment->id }})" id="">
                                      <i class="fs-4 ti ti-file"></i>
                                </a>
                              </td>
                              <td>{{ $attachment->notes }}</td>
                              <td>{{ $attachment->user->name }}</td>
                              <td>{{date('M d, Y', strtotime($attachment->created_at. ' + 6 hours'))}}<strong> at </strong>{{date('h:i A', strtotime($attachment->created_at. ' + 6 hours'))}}</td>
                              <td class="text-center">
                                @if(Auth::user()->id == $attachment->user_id)
                                <a class="" href="javascript:void(0)" id="delt-{{ $attachment->id }}"
                                  data-delete-route="{{ route('student-attachment-delete', $attachment->id) }}" onclick="studentAttachmentDelete('{{ $attachment->id }}')">
                                      <i class="fs-4 ti ti-trash"></i>
                                </a>
                                @endif
                              </td>
                          </tr>
                      @endforeach
                      @else
                      <tr>
                        <th colspan="6" class="text-center text-danger">Record not found!</th>
                      </tr>
                      @endif
                  </tbody>
              </table>
              <div id="attachmentModal" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header d-flex align-items-center border-bottom" >
                        <h4 class="modal-title" id="myModalLabel">
                          Show Attachment
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="populateDate">

                      </div>
                    </div>
                </div>
              </div>
          </div>

      </div>
    </div>
  </div>
<script src="{{ asset('assets/modernize/js/datatable/datatable-advanced.init.js') }}"></script>