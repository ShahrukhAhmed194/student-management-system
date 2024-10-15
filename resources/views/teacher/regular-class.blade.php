<x-admin-layout>
    <div class="pagetitle">
        <h1>Regular Classes</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">All Regular Classes</h5>
                            <!-- <a class="btn btn-primary" href="/users/create">Add New</a> -->
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Class</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classes as $class)
                                <tr>
                                    <th scope="row">{{ $class->id }}</th>
                                    <td>{{ $class->class->name }}</td>
                                    <td>{{ $class->day }}</td>
                                    <td>{{ date('h:i a', strtotime($class->time)) }}</td>
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