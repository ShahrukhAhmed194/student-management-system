<x-student-layout>
    <h5 class="text-center font-weight-bold"> My Classes </h5>
      <section class="section">
        <div class="row">
          @foreach ($classes as $class)
          <div class="col-md-2">
            <div class="card">
              <div class="card-body p-0">
                <img src="{{asset('assets/img/live-online-classes-coursifyme.jpg')}}" class="card-img-top" alt="...">
                <h5 class="card-title pl-3">{{date('d M, Y', strtotime($class->session_date))}}</h5>
                <p class="pl-3"><b>Started At :</b> {{date('h:i A', strtotime($class->session_started))}}<br>
                   <b>Ended At :</b> {{date('h:i A', strtotime($class->session_ended))}}<br>
                   <b>Status :</b> {{$class->status}}<br></p>
              </div>
                <form action="{{route('session-student-specific')}}" method="POST">
                  @csrf
                  <input type="hidden" name="class_session_id" value="{{ $class->id }}" >
                  <input type="hidden" name="id" value="{{$class->class_id}}" >
                  <input type="hidden" name="date" value="{{$class->session_date}}">
                  <div class="pb-3 pr-2 text-right">
                    <button class="btn btn-sm btn-outline-primary">View Class</button>
                  </div>
                </form>
            </div>
          </div>
          @endforeach
        </div>
      </section>
  </x-student-layout>