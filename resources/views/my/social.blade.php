<x-admin-layout>
    <div class="pagetitle">
        <h1>Teacher Social Media Pages</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Social Links</h5>
                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{ route('social.update',$social_links->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="col-md-6">
                                <label for="twitter" class="form-label "><i class="bi bi-twitter"></i> Profile Link</label>
                                <input type="text" name="twitter" class="form-control" id="twitter" value="{{$social_links->twitter_profile}}">
                            </div>
                            <div class="col-md-6">
                                <label for="facebook" class="form-label"><i class="bi bi-facebook"></i> Profile Link</label>
                                <input type="text" name="facebook" class="form-control" id="facebook" value="{{$social_links->facebook_profile}}">
                            </div>
                            <div class="col-md-6">
                                <label for="instagram" class="form-label"><i class="bi bi-instagram"></i> Profile Link</label>
                                <input type="text" name="instagram" class="form-control" id="instagram" value="{{$social_links->instagram_profile}}">
                            </div>
                            <div class="col-md-6">
                                <label for="linkedln" class="form-label"><i class="bi bi-linkedin"></i> Profile Link</label>
                                <input type="text" name="linkedln" class="form-control" id="linkedln" value="{{$social_links->linkedln_profile}}">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100" >Update</button>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-admin-layout>