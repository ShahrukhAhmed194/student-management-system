<x-parent-layout>
    <div class="pagetitle">
        <h1 class="text-left">{{!empty($new_session->sessionClass)? $new_session->sessionClass->name : 'Invalid Class'}}</h1>
    </div>
     <h5 class="text-center font-weight-bold"> RECORDINGS </h5>
     @if(empty($new_session->recording_link))
     <div class="col-sm-4">
       <div class="coming-soon-card">
         <div class="coming-soon-image">
           <img src="https://www.shutterstock.com/image-vector/coming-soon-banner-template-viewfinder-260nw-1793361844.jpg" />
         </div>
         <div class="card-inner">
            @if($new_session->status == 'Completed')
                <div class="header text-center">
                    <h4>Class Has Ended</h4>
                </div>
                <div class="coming-soon-content">
                    <p>Recording Will Be Uploaded Very Soon. Thank You.</p>
                </div>
            @else
                <div class="header text-center">
                    <h4>Class In Session</h4>
                </div>
                <div class="coming-soon-content">
                    <p>Recording Will Be Uploaded After The Class Has Ended. Thank You.</p>
                </div>
            @endif
        </div>
       </div>
     </div>
     @else
     <section>
       <div class="row">
         <div class="card col-md-4">
           <div class="card-body">
             <h5 class="card-title">{{$new_session->sessionClass->name}}</h5>
             <iframe src={{$new_session->recording_link}} width="350" height="300" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen title="REC-1678167183.MP4"></iframe>
           </div>
         </div><!-- End Card with an image on bottom -->
       </div>
     </section>
     @endif
     <hr>
     <section class="section dashboard">
         <div class="row">
             <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                 <div class="card info-card sales-card" style="background-color: #0183CC">
                     <div class="card-body" style="background-color: #FFAE45">
                       <h6 class="card-title font-weight-bold text-light p-4"> Started</h6>
                       <div class="d-flex align-items-center">
                         <div class="card-icon rounded-circle d-flex align-items-center justify-content-center ">
                           <i class="bi bi-play-circle-fill"></i>
                         </div>
                         <div class="ps-3">
                           <h6 class="card-title fs-21 font-weight-bold text-center" style="color: #f8f8f8">
                             {{$new_session != null ? date('h:i A', strtotime($new_session->session_started)) : ''}}
                           </h6>
                         </div>
                       </div>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                 <div class="card info-card sales-card " style="background-color: #EF5C48">
                     <div class="card-body" style="background-color: #0183CC" >
                         <h6 class="card-title font-weight-bold text-light p-4">Ended</h6>
                       <div class="d-flex align-items-center">
                         <div class="card-icon rounded-circle d-flex align-items-center justify-content-center ">
                             <i class="bi bi-stop-circle-fill"></i>
                         </div>
                         <div class="ps-3">
                           <h6 class="card-title fs-21 font-weight-bold " style="color: #f8f8f8">
                             {{$new_session != null ? date('h:i A', strtotime($new_session->session_ended)) : ''}}
                           </h6>
                         </div>
                       </div>
                     </div>
                 </div>
             </div>
             <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                 <div class="card info-card sales-card" style="background-color: #FFAE45">
                     <div class="card-body " style="background-color:  {{($attendance != null && $attendance->status == 1) ? '#2E861E' : '#EF5C48'}}">
                         <h6 class="card-title font-weight-bold text-light p-4"> Attendance</h6>
                       <div class="d-flex align-items-center ">
                           <div class="card-icon rounded-circle d-flex align-items-center justify-content-center ">
                               @if($attendance != null && $attendance->status == 1)
                                   <i class="bi bi-person-circle"></i>
                               @else
                                   <i class="bi bi-question-circle-fill"></i>
                               @endif
                           </div>
                           <div class="ps-3">
                             <h6  class="card-title fs-21 font-weight-bold" style="color: #f8f8f8">
                                 {{($attendance != null && $attendance->status == 1) ? 'Present' : 'Absent'}}
                             </h6>
                           </div>
                       </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <hr>
  <h5 class="text-center font-weight-bold"> {{($projects == '[]' ? '' : 'Projects')}} </h5>
  @if($projects->count() > 0)
  <section class="section">
    <div class="row equal">
      @foreach ($projects as $project)
      <div class="col-md-2 d-flex pb-3">
        <div class="card card-block">
          <div class="card-body">
            <img src="{{asset('assets/img/check-list.png')}}" class="card-img-top" alt="...">
            <h6 class="card-title">{{$project->project->name}}</h6>
            <b>Status</b> : {{$project->project_status}}<br>
            <b>Assessment</b> : {{$project->project_assesment}}<br>
            <b>Comment</b> : {{$project->comments}}
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>
  @endif
     
     <link rel="stylesheet" href="{{asset('assets/css/sessions/student-1.0.0.css')}}">
   </x-parent-layout>