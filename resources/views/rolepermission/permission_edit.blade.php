<form class="" id="permissionfrm" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h4 class="modal-title">Permission Edit</h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label for="edit_name" class="col-sm-3 col-form-label text-right"> Name <i
                    class="text-danger"> *</i></label>
            <div class="col-sm-9">
                <input name="edit_name" class="form-control" type="text"
                       placeholder="" id="edit_name" value="{{ $permissionEditdata->name }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="edit_group_name" class="col-sm-3 col-form-label text-right"> Group Name <i
                    class="text-danger"> *</i></label>
            <div class="col-sm-9">
                <input name="edit_group_name" class="form-control" type="text"
                       placeholder="" id="edit_group_name" value="{{ $permissionEditdata->group_name }}" required>
            </div>
        </div>
    </div>
    <input type="hidden" id="id" name="id" value="{{ $permissionEditdata->id }}">
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="permissionUpdate()">Update</button>
    </div>
</form>