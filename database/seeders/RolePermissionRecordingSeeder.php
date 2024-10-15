<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;

class RolePermissionRecordingSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        /**
         * Enable these options if you need same role and other permission for User Model
         */
        // Create Roles and Permissions
    
        // Permission List as array
        $permissions = [
            [
                'group_name' => 'Recordings',
                'permissions' => [
                    'recording.view',
                    'recording.edit',
                ]
            ]
        ];

        
        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create([
                    'name' => $permissions[$i]['permissions'][$j], 
                    'group_name' => $permissionGroup,
                    'guard_name' => 'web'
                    ]);
            }
        }
        
    }

}