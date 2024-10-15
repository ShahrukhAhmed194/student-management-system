<x-admin-layout>
    <div class="pagetitle">
        <h1 class="text-center">Passed Recording</h1>
    </div>
    <!-- End Page Title -->
    <style>
        .card{
            margin-bottom: 0;
        }
    </style>
    <section class="section">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"></div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                <form class="row g-3" action="{{ route('passed-recording-update') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Recording Information</h5>
                            <div class="">
                                <p>Teacher Name: <strong>{{ $allResults['getPassedRecording']->teacher->name }}</strong></p>
                                <p>Class Name: <strong>{{ $allResults['getPassedRecording']->sessionClass->name }}</strong></p>
                                <p>Session Date: <strong>{{ $allResults['getPassedRecording']->session_date }}</strong></p>
                                <p>
                                    Started Time: <strong>{{ date('h:i A', strtotime($allResults['getPassedRecording']->session_started)) }}</strong> & 
                                    Ended Time: <strong>{{ date('h:i A', strtotime($allResults['getPassedRecording']->session_ended)) }}</strong>
                                </p>
                            </div>
                            <div class="text-center">
                                <iframe src="{{ (!empty($allResults['getPassedRecording']->recording_link) ? $allResults['getPassedRecording']->recording_link : '') }}" width="500" height="350" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="REC-1678167183.MP4"></iframe>
                            </div>
                            <!-- Multi Columns Form -->
                                <input type="hidden" name="id" value="{{ $allResults['getPassedRecording']->id }}">
                                <div class="col-md-12">
                                    <span style="color:#e41111">*</span>
                                    <label for="da_record_id" class="form-label">Recordings</label>
                                    <select id="da_record_id" name="da_record_id" class="form-select choices" required>
                                        <option value="">Select One</option>
                                        @foreach($allResults['recordings'] as $record)
                                            <option value="{{ $record->id }}">
                                                {{ $record->topic }} 
                                                ( {{date('h:i A', strtotime($record->recording_start))}} )
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                                <div class=" align-items-center justify-content-end mt-3">
                                  <a class="btn btn-light" href="/passed-recording?meeting_date={{ $allResults['getPassedRecording']->session_date }}">Back</a>
                                  <button type="submit" class="btn btn-primary float-end">Submit</button>
                                </div>
                              </div>
                        </div> 
                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12"></div>
        </div>
    </section>


</x-admin-layout>