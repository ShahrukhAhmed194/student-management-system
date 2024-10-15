<x-admin-layout>
    <div class="pagetitle">
        <h1>Create Course Page</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Course Form</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{ route('course.store') }}" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <span style="color:#e41111">*</span>
                                <label for="inputName5" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="inputName5">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>

            <!-- <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Example Card</h5>
                        <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
                    </div>
                </div>

            </div> -->
        </div>
    </section>
</x-admin-layout>