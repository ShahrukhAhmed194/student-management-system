
<x-parent-layout>
    <div class="pagetitle">
        <h1>Attendance History</h1>
    </div>
    <div class="loader-div">
        <img class="loader-img" src="{{asset('assets/img/trial-class-registration/loader.gif')}}" style="height: 50%;width: 50%;" />
    </div> 
      <section class="section">
        <div class="card">
            <div class="row p-5">
                <div class="col-md-6">
                    <label for="select-student" class="form-label">Student Name</label>
                    <select id="select-student" name="select-student" class="form-select choices">
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                        <option value="{{$student->user_id}}" >{{$student->user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-outline-primary" style="margin-top: 33px" onclick="attendance_details()">SEARCH</button>
                </div>
            </div>
        </div>
      </section>  
      <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">All Attendance</h5>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table p-2">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Present</th>
                                        <th scope="col">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
      </section>
      <script src="{{asset('assets/js/parent/payment-history-1.0.0.js')}}"></script>  
</x-parent-layout>
