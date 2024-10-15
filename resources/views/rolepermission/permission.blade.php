<x-admin-layout>
    <div class="pagetitle">
        <h1>Role & Permission</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between my-3 mx-2">
                            <h5 class="">All Permission</h5>
                            @if (Auth::guard('web')->user()->can('permission.add'))
                                <button class="btn btn-primary" data-toggle="modal" data-target="#permission-modal">Add New</button>
                            @endif
                        </div>
                <div class="modal fade" id="permission-modal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form class="" id="">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Permission</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3 col-form-label text-right"> Name <i
                                                class="text-danger"> *</i></label>
                                        <div class="col-sm-9">
                                            <input name="name" class="form-control" type="text"
                                                   placeholder="" id="name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="group_name" class="col-sm-3 col-form-label text-right"> Group Name <i
                                                class="text-danger"> *</i></label>
                                        <div class="col-sm-9">
                                            <input name="group_name" class="form-control" type="text"
                                                   placeholder="" id="group_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="permissionSave()">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Group Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($all_permissions as $permission)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->group_name }}</td>
                                    <td>
                                        @if (Auth::guard('web')->user()->can('permission.edit'))
                                            <a href="javascript:void(0)" id="edt-{{ $permission->id }}" title="Edit" data-edit-route="{{ route('permission-edit', $permission->id) }} " data-update-route="{{ route('permission-update', $permission->id) }}" onclick="permissionEdit('{{ $permission->id }}')"  class=""><i class="bi bi-pencil-square"></i></a> 
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
    </section>
    <div class="modal fade" id="edit-permission-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content edit-permission-load">

            </div>
        </div>
    </div>
</x-admin-layout>


<script type="text/javascript">
    //============= its for permission save ==============
    function permissionSave() {
        var fd = new FormData();
        var name = $("#name").val();
        var group_name = $("#group_name").val();
        
        if (name == "") {
            toastr.error('Name must be required', 'Permission');
            $("#name").focus();
            return false;
        }
        if (group_name == "") {
            toastr.error('Group Name must be required', 'Permission');
            $("#group_name").focus();
            return false;
        }

        fd.append("name", name);
        fd.append("group_name", group_name);
        $.ajax({
            url: "{{route('permission-save')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            data: fd,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            success: function (r) {
                var response = $.parseJSON(r);
                console.log(response);
                
                if (response.success == true) {
                    toastr.success(response.message, response.title);
                } else if (response.success == 'exist') {
                    toastr.warning(response.message, response.title);
                } else {
                    toastr.error(response.message, response.title);
                }
                $('#permission-modal').modal('hide');
                $("#name").val('');
                $("#group_name").val('');
                location.reload();
            },
        });
    }


//============= its for permissionEdit ===============
    function permissionEdit(id) {
        var fd = new FormData();
        var editmode_url = $("#edt-" + id).attr('data-edit-route');
        var update_url = $("#edt-" + id).attr('data-update-route');

        fd.append("id", id);
        fd.append("update_url", update_url);

        $.ajax({
            url: editmode_url,
            type: "GET",
            data: fd,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            success: function (r) {
                $('#edit-permission-modal').modal('show');
                $(".edit-permission-load").html(r);
                $("#permissionfrm").attr("action", update_url);
            },
        });
    }

////============== its for permissionUpdate ============
    function permissionUpdate() {
        var fd = new FormData();
        var name = $("#edit_name").val();
        var group_name = $("#edit_group_name").val();
        var submit_action = $("#permissionfrm").attr("action");

        var id = $("#id").val();

        fd.append("id", id);
        fd.append("name", name);
        fd.append("group_name", group_name);
        fd.append("_method", "PUT");
        
        $.ajax({
            url: submit_action,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            data: fd,
            cache: false,
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            success: function (r) {
                var response = $.parseJSON(r);
                if (response.success == true) {
                    toastr.success(response.message, response.title);
                } else if (response.success == 'exist') {
                    toastr.warning(response.message, response.title);
                } else {
                    toastr.error(response.message, response.title);
                }
                $('#edit-permission-modal').modal('hide');
                $("#edit_name").val('');
                $("#edit_group_name").val('');
                location.reload();
            },
        });
    }


    function permissionDelete(id) {
        var delete_url = $("#delt-" + id).attr('data-delete-route');
        var check = confirm('Are you sure');
        if (check == true) {
            $.ajax({
                type: 'DELETE',
                url: delete_url,
                data: {"_token": "{{ csrf_token() }}"},
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        toastr.success(response.message, response.title);
                    } else if (response.success == 'exist') {
                        toastr.warning(response.message, response.title);
                    } else {
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