{{-- <x-parent-layout>
  @if(sizeof($students) > 0)
    <h5 class="text-center font-weight-bold"> {{$students[0]->user->name}}'s Class Details </h5>
      <section class="section">
        <div class="row">
          @foreach ($students as $student)
          <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="card">
              <div class="card-body p-0">
                <img src="{{asset('assets/img/live-online-classes-coursifyme.jpg')}}" class="card-img-top" alt="...">
                <h5 class="card-title pl-3">{{date('d M, Y', strtotime($student->session_date))}}<br></h5>
                <p class="pl-3">
                  <b>Class : </b>{{$student->class->name}}<br>
                  <b>Time: </b>{{date('h:i A', strtotime($student->session_started))}}<br>
                  <b>Status : </b>{{$student->status}}<br>
                  <b>Comments : </b>{{$student->comments}}<br>
                </p>
              </div>
              <form action="{{route('session-parent-specific')}}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{$student->class->id}}" >
                <input type="hidden" name="student_id" value="{{$student->user_id}}">
                <input type="hidden" name="date" value="{{$student->session_date}}">
                <div class="pb-3 pr-2 text-right">
                  <button class="btn btn-sm btn-outline-primary">View Class</button>
                </div>
              </form>
            </div>
          </div>
          @endforeach
        </div>
      </section>
  @endif
</x-parent-layout> --}}
<x-parent-layout>
  @if(sizeof($students) > 0)
    <h5 class="text-center font-weight-bold"> {{$students[0]->user->name}}'s Class Details </h5>
      <section class="section">
        <div class="row">
          @foreach ($getClassSessionRecords as $student)
          {{-- {{dd($student->classSession)}} --}}
          <div class="col-lg-2 col-md-3 col-sm-4">
            <div class="card">
              <div class="card-body p-0">
                <img src="{{asset('assets/img/live-online-classes-coursifyme.jpg')}}" class="card-img-top" alt="...">
                <h5 class="card-title pl-3">{{date('d M, Y', strtotime($student->classSession->session_date))}}<br></h5>
                <p class="pl-3">
                  <b>Class : </b>{{$student->classSession->sessionClass->name}}<br>
                  <b>Time: </b>{{date('h:i A', strtotime($student->classSession->session_started))}}<br>
                  <b>Status : </b>{{ ucwords($student->status) }}<br>
                  <b>Comments : </b>{{$student->classSession->comments}}<br>
                </p>
              </div>
              <form action="{{route('session-parent-specific')}}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $student->classSession->sessionClass->id }}" >
                <input type="hidden" name="student_id" value="{{ $students[0]->user->id }}">
                <input type="hidden" name="date" value="{{ $student->classSession->session_date }}">
                <input type="hidden" name="class_session_record_id" value="{{ $student->id }}">
                <div class="pb-3 pr-2 text-right">
                  <button class="btn btn-sm btn-outline-primary">View Class</button>
                </div>
              </form>
            </div>
          </div>
          @endforeach
        </div>
      </section>
  @endif
</x-parent-layout>
