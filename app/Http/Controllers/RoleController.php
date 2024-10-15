<?php

namespace App\Http\Controllers;

use App\DAO\WebDao\PermissionDao;
use App\Traits\validators\RoleValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Traits\UserService;
use App\Traits\RoleService;
use App\Models\User;
use DataTables;

class RoleController extends Controller{

    use RoleValidator, UserService, RoleService;

    public $user;
    private $permissionDao;
    
    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
        
        $this->permissionDao = new PermissionDao();
    }

    public function index(){
        if (is_null($this->user) || !$this->user->can('role.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any role !');
        }
        
        $roles = Role::with(['permissions'])->get();
        
        return view('rolepermission.index', compact('roles'));
    }

    public function create(){
        
        if (is_null($this->user) || !$this->user->can('role.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any role !');
        }
        
        $permissionGroups = $this->permissionDao->getGroupByPermission();

        return view('rolepermission.addRole', compact('permissionGroups'));
    }

    public function store(Request $request){
        
        $validator = $this->validateNewRole($request);
        
        if ($validator->fails()) {
            return redirect(url('/roles/create'))
                    ->withErrors($validator)
                    ->withInput();
        }
        
        $permissions = $request->input('permissions');
        
        if (empty($permissions)) {
            return redirect()->back()->with('warning', 'Please select at least one permission.')->withInput();
        }

        $role = $this->createRole($request->name, 'web');
        
        $role->syncPermissions($permissions);

        toastr()->success('Role created successfully.');
        return redirect()->route('roles.create');
    }

   
    public function show($id){
        
    }

    public function edit($id){ 
        if (!Auth::check()) {
            return redirect('/');
        }
        if (is_null($this->user) || !$this->user->can('role.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        }
        
        $role = Role::findById($id, 'web');
        
        $permissionGroups = $this->permissionDao->getGroupByPermission();

        return view('rolepermission.role_edit', compact('role', 'permissionGroups'));
    }

    public function update(Request $request, $id){
        
        $validator = $this->validUpdatedForm($request);

        if ($validator->fails()) {
            return redirect(url('/roles/'.$id.'/edit'))
                    ->withErrors($validator)
                    ->withInput();
        }

        $permissions = $request->input('permissions');
        
        if (empty($permissions)) {
            return back()->with('warning', 'Please select at least one permission.')->withInput();
        }
        
        $this->updateRole($id, $request->name, $permissions);

        toastr()->success('Role has been updated.');
        return redirect()->route('roles.index'); 
    }

    public function destroy($id){
        if (is_null($this->user) || !$this->user->can('role.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any role !');
        }
        $role = $this->deleteRole($id);
        $response = array(
            'success' => true,
            'title' => 'Role',
            'message' => 'Deleted Successfully'
        );
        return json_encode($response);
    }

    public function permission(Request $request) {
        if (!Auth::check()) {
            return redirect('/');
        }
        if (is_null($this->user) || !$this->user->can('permission.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any permission !');
        }

        $all_permissions = $this->getAllPermission();
        return view('rolepermission.permission', compact('all_permissions'));
    }
    
     public function permission_save(Request $request) {
        $name = $request->name;
        $group_name = $request->group_name;

        $permission = $this->createPermission($name, $group_name);
        
        $response = array(
            'success' => true,
            'title' => 'Permission',
            'message' => 'Added Successfully'
        );
        return json_encode($response);
    }
    
    public function permission_edit($id) {
        if (!Auth::check()) {
            return redirect('/');
        }
        $permissionEditdata = Permission::findOrFail($id);

        return view('rolepermission.permission_edit', with(compact('permissionEditdata')));
    }
    
    public function permission_update(Request $request, $id) {
        $name = $request->name;
        $group_name = $request->group_name;
        $permission = $this->updatePermission($id, $name, $group_name);

        $response = array(
            'success' => true,
            'title' => 'Permission',
            'message' => 'Updated Successfully'
        );
        return json_encode($response);
    }
    
    public function permission_delete($id){
        $this->deletePermission($id);
        return json_encode($response);
    }

    public function assign_role_form(){
        if (is_null($this->user) || !$this->user->can('assignrole.add')) {
            abort(403, 'Sorry !! You are Unauthorized to add any assign role !');
        }
        $roles = Role::all();
        $users = User::whereNotIn('user_type', [User::USER_TYPE_STUDENT, User::USER_TYPE_PARENT, User::USER_TYPE_TEACHER])->get();
        $allresults = array(
            'roles' => $roles,
            'users' => $users,
            );
        return view('rolepermission.assignrole_form', compact('allresults'));
    }

    public function assign_role(Request $request){
        $user_id = $request->user_id;
        $user = User::find($user_id);

        if($request->roles){
            $user->assignRole($request->roles);
         }

        toastr()->success('Role assigned successfully!!');
        return redirect()->route('assign-role');
    }

    public function assignrole_list(){
        if (!Auth::check()) {
            return redirect('/');
        }
        if (is_null($this->user) || !$this->user->can('assignrole.list')) {
            abort(403, 'Sorry !! You are Unauthorized to list view any assign role !');
        }

        $assignUser = $this->getAssignedUser();

        $allresults = array(
            'assignUser' => $assignUser,
            );
        return view('rolepermission.assignrole_list', compact('allresults'));
    }

    public function assignuserrole_edit($id){
        if (is_null($this->user) || !$this->user->can('assignrole.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any assign role !');
        }
        $assigned_user = User::findOrFail($id);

        $assignedRole = $this->getAssignedRole($assigned_user->id);

        $assigned_roles = array();
        foreach ($assignedRole as $key => $value) {
            $assigned_roles[]=$value->role_id;
        }

        $roles = Role::all();
        $users = User::whereIn('user_type', array(User::USER_TYPE_SUPER_ADMIN, User::USER_TYPE_TEACHER, User::USER_TYPE_ADMIN, User::USER_TYPE_PARENT, User::USER_TYPE_SALES_EXECUTIVE, User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE))->get();

        $allresults = array(
            'roles' => $roles,
            'users' => $users,
            'assigned_user' => $assigned_user,
            'assigned_roles' => $assigned_roles,
            );
        return view('rolepermission.assignuserrole_edit', compact('allresults'));
    }

    public function assignedrole_update(Request $request, $id){

        $assigned_userrole = $this->getAssignedUserRole($id);
        
        $assigned_userrole->delete();
        $user = User::find($id);

        if($request->roles){
            $user->assignRole($request->roles);
         }

        toastr()->success('Role assigned updated successfully!!');
        return redirect()->route('assign-role-list');
    }

    public function assignuserrole_delete($id){
        if (is_null($this->user) || !$this->user->can('assignrole.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any assign role !');
        }
        $checkrecord = $this->getAssignedUserRole($id);

        if ($checkrecord) {
            $assigned_userrole = $this->getAssignedUserRole($id);
            $assigned_userrole->delete();
        }

        toastr()->success('This record deleted successfully done!!');
        return redirect()->route('assign-role-list');
    }
}
