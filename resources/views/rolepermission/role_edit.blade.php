@php
use App\Traits\UserService;
@endphp
<x-dashboard.admin-layout>

    <x-slot name="style">
        <style>
            .form-check-input:checked {
                background-color: #012970;
                border-color: #012970;
            }
        </style>
    </x-slot>

    <x-slot name='title'>Edit Role - Dreamers Academy</x-slot>

    <div class="container-fluid">

        <x-inc.breadcrumb title="Edit Role" />

        @if(session('warning'))
            <div class="alert alert-warning text-warning" role="alert">
                <strong>{{ session('warning') }}</strong>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <form action="{{ route('roles.update', $role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" class="mb-1" style="font-weight: 700">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter a Role Name" value="{{ old('name', $role->name) }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex" style="align-items: center; justify-content: space-between;">
                                <h4>Permissions</h4>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="all_permission_check">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($permissionGroups as $key => $permissions)
                            <div class="col-md-3">
                                <div class="card w-100">
                                    <div class="card-body all_permission_block">
                                        <div class="mb-3 d-flex" style="border-bottom: 1px solid #3333; align-items: center; justify-content: space-between;">
                                            <h4 class="card-title">{{ $key }}</h4>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input permission_group_check" type="checkbox" id="group_permission_{{ $key }}">
                                            </div>
                                        </div>

                                        <div class="row permission_block">
                                            @foreach($permissions as $permission)
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input permission_check" type="checkbox" id="checkPermission{{ $permission->id }}" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} value="{{ $permission->name }}">
                                                        <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ wordwrap($permission->name, 24, "\n", true) }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="card">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <a href="{{ route('roles.index') }}" class="btn btn-light"> Back
                            </a>

                            <button type="submit" class="btn btn-primary float-right">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function(){
                $('#all_permission_check').click(function(){
                    if($(this).is(':checked')){
                        $('input[type=checkbox]').prop('checked', true);
                    }else{
                        $('input[type=checkbox]').prop('checked', false);
                    }
                });

                $(".permission_group_check").click(function (e) {
                    let $this = $(this);
                    if (e.target.checked == true) {
                        $this.closest(".all_permission_block").find(".permission_block").find(".permission_check").prop('checked', true)
                    } else {
                        $this.closest(".all_permission_block").find(".permission_block").find(".permission_check").prop('checked', false)
                    }
                })
            });
        </script>
    </x-slot>

</x-dashboard.admin-layout>