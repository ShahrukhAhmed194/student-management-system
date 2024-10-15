<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolePermissionStudentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'group_name' => 'Student',
                'permissions' => [
                    'student.terminate',
                    'student.re_admit',
                    'student.graduate',
                    'student.on_hold',
                    'student.delete',
                    'student.update',
                ]
            ]
        ];

        
        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {

                $permission = Permission::create([
                    'name' => $permissions[$i]['permissions'][$j], 
                    'group_name' => $permissionGroup,
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}
