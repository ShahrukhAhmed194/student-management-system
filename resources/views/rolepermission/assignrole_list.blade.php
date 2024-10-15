@php
use App\Traits\UserService;
@endphp

<x-dashboard.admin-layout>

    <x-slot name='title'>Assign User Role List - Dreamers Academy</x-slot>

    <div class="container-fluid">

        <x-inc.breadcrumb title="Assign Role list" />

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive overflow-auto">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">Assign User Role List</h5>
                            @if (Auth::guard('web')->user()->can('assignrole.add'))
                                <a href="{{ route('assign-role') }}" class="btn btn-primary">Assign Role</a>
                            @endif
                        </div>
                        <table id="basic-datatable" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Role Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($allresults['assignUser'] as $single)
                            <?php 
                            $getuserRole = DB::table('model_has_roles')
                                    ->select('model_has_roles.*', 'roles.name')
                                    ->join('roles','roles.id','=','model_has_roles.role_id')
                                    ->where('model_has_roles.model_id', $single->model_id)
                                    ->get();
                                    
                            $getRole = UserService::getRoleName($single->role_id);
                            ?>
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $single->name }}</td>
                                    <td>
                                        @foreach($getuserRole as $role)
                                            <span class="badge bg-info mr-1">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (Auth::guard('web')->user()->can('assignrole.edit'))
                                            <a href="assignuserrole-edit/{{$single->id}}"><i class="ti ti-edit"></i></a>
                                        @endif
                                        @if (Auth::guard('web')->user()->can('assignrole.delete'))
                                            <a href="assignuserrole-delete/{{$single->id}}" onclick="return confirm('Are you sure, want to delete this record!')"><i class="ti ti-trash"></i></a>
                                        @endif
                                    </td>
                                
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-permission-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content edit-permission-load">

            </div>
        </div>
    </div>
</x-dashboard.admin-layout>