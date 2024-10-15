<x-dashboard.admin-layout>

    <x-slot name='title'>Role List - Dreamers Academy</x-slot>

    <div class="container-fluid">

        <x-inc.breadcrumb title="Role List" />

        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('role.add')
                        <div class="card-header">
                            <a href="{{ route('roles.create') }}" class="btn btn-primary float-end m-3 align-items-center px-3" id="add-new">
                                <span class="d-none d-md-block font-weight-medium fs-3"> <i class="ti ti-plus me-0 me-md-1 fs-4"></i>Add Role</span>
                            </a>
                        </div>
                    @endcan

                    <div class="card-body table-responsive overflow-auto">
                        <!-- Table with stripped rows -->
                        <table id="basic-datatable" class="table border table-striped table-bordered display table-responsive">
                            <thead>
                                <tr>
                                    <th width="5%">Sl No</th>
                                    <th width="10%">Name</th>
                                    <th width="80%">Permission</th>
                                    @canany(['role.edit', 'role.delete'])
                                        <th width="5%" class="text-center">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as  $role)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="row">
                                                @php
                                                    $permissions = $role->permissions->groupBy('group_name');
                                                @endphp
                                                @foreach($permissions as $key => $groupPermission)
                                                    <div class="col-md-4">
                                                        <div class="card w-100">
                                                            <div class="card-body all_permission_block">
                                                                <div class="mb-3 d-flex" style="border-bottom: 1px solid #3333; align-items: center; justify-content: space-between;">
                                                                    <h4 class="card-title">{{ $key }}</h4>
                                                                </div>

                                                                @foreach($groupPermission as $permission)
                                                                    <div class="row permission_block">
                                                                        <div class="col-md-12 mb-2">
                                                                            <div class="d-flex align-items-baseline">
                                                                                <span class="round-8 rounded-circle me-1 d-inline-block" style="background-color: #012970;"></span>
                                                                                <span>{{ wordwrap($permission->name, 25, "\n", true) }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        @canany(['role.edit', 'role.delete'])
                                            <td>
                                                <div class="dropdown dropstart">
                                                    <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ti ti-dots-vertical fs-6"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                                        @can('role.edit')
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('roles.edit', $role->id) }}">
                                                                    <i class="fs-4 ti ti-edit"></i>Edit
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('role.delete')
                                                            <li>
                                                                <a class="dropdown-item d-flex align-items-center gap-3" href="javascript:void(0)"  id="delt-{{ $role->id }}"
                                                                   data-delete-route="{{ route('roles.destroy', $role->id) }}" onclick="roleDelete('{{ $role->id }}')"
                                                                >
                                                                    <i class="fs-4 ti ti-trash"></i>Delete
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            //    ============ its for role delete ==========
            function roleDelete(id) {
                var delete_url = $("#delt-" + id).attr('data-delete-route');
                var check = confirm('Are you sure');
                if (check == true) {
                    $.ajax({
                        type: 'DELETE',
                        url: delete_url,
                        data: {"_token": "{{ csrf_token() }}"},
                        dataType: 'json',
                        success: function (response) {
                            console.log(response);
                            if (response.success == true) {
                                toastr.success(response.message, response.title);
                            }  else {
                                toastr.error(response.message, response.title);
                            }
                            location.reload();
                        },
                        error: function () {
                        }
                    });
                }
            }
        </script>
    </x-slot>

</x-dashboard.admin-layout>
