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
                                <select id="inputState" name="class_id" class="form-select" required>
                                    <option value="">- Please Select -</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ $class->id == $selected['class_id'] ? 'selected' : ''}}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="inputState" class="col-form-label">Select Quiz</label>
                                <select id="inputState" name="quiz_id" class="form-select">
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

                        <form action="{{ route('quiz-assesment.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="class_id" value="{{ $selected['class_id'] }}">
                            <input type="hidden" name="teacher_id" value="{{ $selected['teacher_id'] }}">
                            <input type="hidden" name="quiz_id" value="{{ $selected['quiz_id'] }}">


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
                                    @foreach($students as $key=>$student)
                                    <tr>
                                        <td>
                                            {{ $student->user->name }}
                                            <input class="form-input" type="hidden" name="assesments[{{ $key}}][student_id]" value="{{ $student->user_id }}" id="flexSwitchCheckChecked">
                                        </td>
                                        <td>
                                            <select id="inputState" name="assesments[{{ $key}}][quiz_status]" class="form-select">
                                                <option selected>- Please Select -</option>
                                                <option value="DID_NOT_START">Didn't Start</option>
                                                <option value="IN_PROGRESS">In Progress</option>
                                                <option value="COMPLETE">Complete</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="assesments[{{ $key}}][mark]" class="form-control">
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <textarea class="form-control" name="assesments[{{ $key}}][comments]" rows="5"></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- <tr>
                                        <td>Bridie Kessler</td>
                                        <td>
                                            <select id="inputState" class="form-select">
                                                <option selected>- Please Select -</option>
                                                <option value="DID_NOT_START">Didn't Start</option>
                                                <option value="IN_PROGRESS">In Progress</option>
                                                <option value="COMPLETE">Complete</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="inputState" class="form-select">
                                                <option selected>- Please Select -</option>
                                                <option value="BELOW_AVERAGE">Below Average</option>
                                                <option value="AVERAGE">Average</option>
                                                <option value="GOOD">Good</option>
                                                <option value="EXCELLENT">Excellent</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <textarea class="form-control" rows="5"></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ashleigh Langosh</td>
                                        <td>
                                            <select id="inputState" class="form-select">
                                                <option selected>- Please Select -</option>
                                                <option value="DID_NOT_START">Didn't Start</option>
                                                <option value="IN_PROGRESS">In Progress</option>
                                                <option value="COMPLETE">Complete</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select id="inputState" class="form-select">
                                                <option selected>- Please Select -</option>
                                                <option value="BELOW_AVERAGE">Below Average</option>
                                                <option value="AVERAGE">Average</option>
                                                <option value="GOOD">Good</option>
                                                <option value="EXCELLENT">Excellent</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <textarea class="form-control" rows="5"></textarea>
                                            </div>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>

                            <div style="text-align: right">
                                <button type="submit" class="btn btn-primary">Submit Assessment</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>