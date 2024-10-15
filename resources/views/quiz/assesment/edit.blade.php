<x-admin-layout>
    <div class="pagetitle" style="padding-bottom: 10px">
        <h1>Project Assessment</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Class Details</h5>

                        <form class="row g-3">
                            <div>
                                <label for="inputState" class="col-form-label">Select Class</label>
                                <select disabled id="inputState" name="class_id" class="form-select" required>
                                    <option value="">- Please Select -</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $class->id == $selected['class_id'] ? 'selected' : ''}}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="inputState" class="col-form-label">Select Quiz</label>
                                <select disabled id="inputState" name="quiz_id" class="form-select">
                                    <option selected>- Please Select -</option>
                                    @foreach($quizzes as $quiz)
                                    <option value="{{ $quiz->id }}" {{ $quiz->id == $selected['quiz_id'] ? 'selected' : ''}}>Quiz#{{ $quiz->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="text-align: right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Class Name</h5>
                        <p>
                            <strong>Quiz: 1</strong>
                        </p>

                        <form action="{{ route('quiz-assesment.update', $assesment->id) }}" method="POST">
                            @csrf @method('PUT')

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Quiz Status</th>
                                        <th scope="col">Quiz Mark</th>
                                        <th scope="col">Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            {{ $assesment->student->name }}
                                        </td>
                                        <td>
                                            <select id="inputState" name="quiz_status" class="form-select">
                                                <option>- Please Select -</option>
                                                <option value="DID_NOT_START" {{ $assesment->quiz_status == 'DID_NOT_START' ? 'selected' : '' }}>Didn't Start</option>
                                                <option value="IN_PROGRESS" {{ $assesment->quiz_status == 'IN_PROGRESS' ? 'selected' : '' }}>In Progress</option>
                                                <option value="COMPLETE" {{ $assesment->quiz_status == 'COMPLETE' ? 'selected' : '' }}>Complete</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="mark" value="{{$assesment->mark}}" class="form-control">
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <textarea class="form-control" name="comments" rows="5">{{$assesment->comments}}</textarea>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <div style="text-align: right">
                                <button type="submit" class="btn btn-primary">Update Assessment</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>