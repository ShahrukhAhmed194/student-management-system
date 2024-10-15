<x-admin-layout>
    <link rel="stylesheet" href="{{asset('assets/css/loader-1.0.0.css')}}">
    <section class="section">
        <div class="loader-div">
            <img class="loader-img" src="{{asset('assets/img/trial-class-registration/loader.gif')}}" style="height: 50%;width: 50%;" />
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card pt-2 overflow-auto">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">Meeting Date</th>
                                <th scope="col">Meeting Started</th>
                                <th scope="col">Class</th>
                                <th scope="col">Session Information</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <form action="/create-custom-session" method="POST">
                            @csrf
                        <tbody>
                            <td>
                                <input type="date" name="meetingDate" class="form-control" id="meetingDate" onfocusout="showRecordings()">
                                @error('meetingDate')
                                    <span class="text-danger font-weight-bold">{{ $message }}</span>
                                @enderror
                            </td>
                            <td>
                                <input type="time" name="startTime" class="form-control" id="startTime">
                                @error('startTime')
                                    <span class="text-danger font-weight-bold">{{ $message }}</span>
                                @enderror
                            </td>
                            <td>
                            <div class="input-group">
                                <select name="classId" id="classId" class="form-control">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                    <option value="{{$class->id}}">{{$class->name}}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-append">
                                    <span class="input-group-text bg-white" >
                                        <i class="bi bi-laptop"></i>
                                    </span>
                                </span>
                            </div>
                            @error('classId')
                                <span class="text-danger font-weight-bold">{{ $message }}</span>
                            @enderror
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="classRecording" id="classRecording" class="form-control">
                                        
                                    </select>
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-white" >
                                            <i class="bi bi-camera-video"></i>
                                        </span>
                                    </span>
                                </div>
                                @error('classRecording')
                                    <span class="text-danger font-weight-bold">{{ $message }}</span>
                                @enderror
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </td>
                        </tbody>
                        </form>
                    </table>
                </div>
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-6 ">
                                <a class="btn btn-light" href="{{ url()->previous() }}">Back</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{asset('assets/js/sessions/create-1.0.0.js')}}"></script>
</x-admin-layout>