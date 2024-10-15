<x-admin-layout>
    <div class="pagetitle">
        <h1 class="text-center">New Quiz</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12"></div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Quiz Form</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{ route('quiz.store') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="inputName5" class="form-label">Quiz Link</label>
                                <input type="text" name="form_link" class="form-control" id="inputName5">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12"></div>
        </div>
    </section>


</x-admin-layout>