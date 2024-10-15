<?php
namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\User;

trait RoleService{

	public function createRole($name, $guard){
        $role = Role::create([
	        	'name' => $name,
	        	'guard_name' => $guard
	        	]);
        return $role;
    }

	public function updateRole($id, $name, $permissions){
        $role = Role::findById($id, 'web');
		$role->name = $name;
        $role->save();
        $role->syncPermissions($permissions);
        return $role;
    }

    public function deleteRole($id){
        $role = Role::findById($id, 'web');
        if (!is_null($role)) {
            $role->delete();
        }
    }

    public function getAllPermission(){
    	$all_permissions = Permission::select('*')->orderBy('id', 'desc')->get();
    	return $all_permissions;
    }

    public function createPermission($name, $group_name){
    	$permission = Permission::create([
            'name' => $name,
            'group_name' => $group_name,
            'guard_name' => 'web',
            "created_at" => date('Y-m-d H:m:s'),
        ]);
        return $permission;
    }

    public function updatePermission($id, $name, $group_name){
    	 $permissiondata = Permission::where("id", $id)->update([
            "name" => $name,
            "group_name" => $group_name,
            "updated_at" => date('Y-m-d H:m:s'),
        ]);
    }

    public function deletePermission($id){
    	$checkrecord = Permission::findOrFail($id);

        if ($checkrecord) {
            $permission = Permission::where("id", "=", $id);
            $permission->delete();

            $response = array(
                'success' => true,
                'title' => 'Permission',
                'message' => 'Deleted Successfully'
            );
        }
    }

    public function getAssignedUser(){
    	$assignUser = DB::table('model_has_roles')
			        ->select('users.id','users.name', 'model_has_roles.role_id', 'model_has_roles.model_id')
			        ->join('users','users.id','=','model_has_roles.model_id')
                    ->whereIn('users.user_type', [User::USER_TYPE_SUPER_ADMIN, User::USER_TYPE_ADMIN, User::USER_TYPE_SALES_EXECUTIVE, User::USER_TYPE_CUSTOMER_SUPPORT_EXECUTIVE])
			        ->groupBy('model_has_roles.model_id')
			        ->get();
        return $assignUser;
    }

    public function getAssignedRole($assigned_user_id){
    	$assignedRole = DB::table('model_has_roles')
                        ->select('model_has_roles.role_id', 'model_has_roles.model_id')
                        ->where('model_has_roles.model_id', $assigned_user_id)
                        ->get();
                        return $assignedRole;
    }

    public function getAssignedUserRole($id){
    	$assigned_userrole = DB::table('model_has_roles')
                            ->where("model_id", "=", $id);
        return $assigned_userrole;
    }
    
}