<x-dashboard.admin-layout>

    <x-slot name='title'>Assign Role - Dreamers Academy</x-slot>

    <!-- End Page Title -->
    <div class="container-fluid">

        <x-inc.breadcrumb title="Assign Role" />

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <form action="{{ route('assigned-role') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label for="assign_roles" class="mb-1">Role Name</label>
                                        <select class="form-control placeholder-single select2" id="assign_roles" name="roles[]" multiple data-placeholder="-- select role --">
                                            @foreach($allresults['roles'] as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="user_id" class="mb-1">User</label>
                                        <select class="form-control placeholder-single select2" id="user_id" name="user_id">
                                            <option value="">-- select one -- </option>
                                            @foreach($allresults['users'] as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>


                            
                        </div>
                    </div>
                    <div class="card">
                            <div class="d-flex justify-content-between my-3 mx-2">
                                <a href="{{ route('assign-role-list') }}" class="btn btn-light">Back</a>

                               <button type="submit" class="btn btn-primary float-right" id="studentsave_btn">Assigned</button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard.admin-layout>