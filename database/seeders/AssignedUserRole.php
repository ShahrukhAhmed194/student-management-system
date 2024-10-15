<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AssignedUserRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         /**
         * Enable these options if you need same role and other permission for User Model
         */
        // Create Roles and Permissions
    
        // Permission List as array
        $permissions = [
            [
                'group_name' => 'Trial Class',
                'permissions' => [
                    'trial_class.assignedUser'
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
