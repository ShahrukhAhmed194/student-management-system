<x-admin-layout>
    <div class="pagetitle">
        <h1>Student Projects</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">All Student Projects</h5>
                            <a class="btn btn-primary" href="/quiz-assesment/create">Add New</a>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Class</th>
                                    <th scope="col">Quiz</th>
                                    <th scope="col">Student</th>
                                    <th scope="col">Quiz Status</th>
                                    <th scope="col">Mark</th>
                                    <th scope="col">Comments</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assesments as $assesment)
                                <tr>
                                    <th scope="row">{{ $assesment->id }}</th>
                                    <td>{{ $assesment->class->name }}</td>
                                    <td>Quiz#{{ $assesment->quiz->id }}</td>
                                    <td>{{ $assesment->student->name }}</td>
                                    <td>{{ $assesment->quiz_status }}</td>
                                    <td>{{ $assesment->mark }}</td>
                                    <td>{{ $assesment->comments }}</td>
                                    <td>
                                        <a href="/quiz-assesment/{{$assesment->id}}/edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</x-admin-layout>