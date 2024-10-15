<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;

trait UserService{

     public static function getpermissionGroups() {
        $permission_groups = DB::table('permissions')->select('group_name as name')->groupBy('group_name')->get();
        return $permission_groups;
    }

     public static function getpermissionsByGroupName($groupname) {
        $permission_groups = DB::table('permissions')->select('id', 'name')
                ->where('group_name', $groupname)
                ->get();
        return $permission_groups;
    }

     public static function roleHasPermissions($role, $permissions) {
        $hasPermission = TRUE;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = FALSE;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }


    public static function getRoleName($role_id) {
        $roleName = DB::table('roles')
                            ->select('name')
                            ->where('id', $role_id)
                            ->get();
        return $roleName;
    }
    
}