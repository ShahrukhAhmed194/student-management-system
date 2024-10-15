<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Schema;

class RolePermissionSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Schema::disableForeignKeyConstraints();
        \DB::table('role_has_permissions')->truncate();
        \DB::table('model_has_roles')->truncate();
        \DB::table('model_has_permissions')->truncate();
        \DB::table('roles')->truncate();
        \DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        /**
         * Enable these options if you need same role and other permission for User Model
         */
        // Create Roles and Permissions
    
        // Permission List as array
        $permissions = [
            [
                'group_name' => 'Dashboard',
                'permissions' => [
                    'dashboard.add',
                    'dashboard.view',
                ]
            ],
            [
                'group_name' => 'Classes',
                'permissions' => [
                    'classes.add',
                    'classes.edit',
                    'classes.list',
                    'classes.delete',
                ]
            ],
            [
                'group_name' => 'Class Schedule',
                'permissions' => [
                    'class_schedule.add',
                    'class_schedule.edit',
                    'class_schedule.list',
                    'class_schedule.delete',
                ]
            ],
            [
                'group_name' => 'Quiz',
                'permissions' => [
                    'quiz.add',
                    'quiz.edit',
                    'quiz.list',
                    'quiz.delete',
                ]
            ],
            [
                'group_name' => 'Courses',
                'permissions' => [
                    'courses.add',
                    'courses.edit',
                    'courses.list',
                    'courses.delete',
                    'course_track.add',
                    'course_track.edit',
                    'course_track.list',
                    'course_track.delete',
                    'course_level.add',
                    'course_level.edit',
                    'course_level.list',
                    'course_level.delete',
                    'codingforkids.list',
                ]
            ],
            [
                'group_name' => 'Projects',
                'permissions' => [
                    'projects.add',
                    'projects.edit',
                    'projects.list',
                    'projects.delete',
                ]
            ],
            [
                'group_name' => 'Project Assesment',
                'permissions' => [
                    'projectassesment.add',
                    'projectassesment.edit',
                    'projectassesment.list',
                    'projectassesment.delete',
                ]
            ],
            [
                'group_name' => 'Trial Class',
                'permissions' => [
                    'trial_class.add',
                    'trial_class.edit',
                    'trial_class.list',
                    'trial_class.delete',
                    'trialclass_schedule.add',
                    'trialclass_schedule.edit',
                    'trialclass_schedule.list',
                    'trialclass_schedule.delete',
                ]
            ],
            [
                'group_name' => 'Users',
                'permissions' => [
                    'students.add',
                    'students.edit',
                    'students.list',
                    'students.delete',
                    'graduated_student.list',
                    'terminated_student.list',
                    'parents.add',
                    'parents.edit',
                    'parents.list',
                    'parents.delete',
                    'users.add',
                    'users.edit',
                    'users.list',
                    'users.delete',
                ]
            ],
            [
                'group_name' => 'Report',
                'permissions' => [
                    'attendance_report.list',
                    'comprehensive_report.list',
                ]
            ],
            [
                'group_name' => 'Payments',
                'permissions' => [
                    'payment.add',
                    'payment.edit',
                    'payment.list',
                    'payment.delete',
                ]
            ], 
            [
                'group_name' => 'Attendance',
                'permissions' => [
                    'attendance.add',
                    'attendance.edit',
                    'attendance.list',
                    'attendance.delete',
                    'attendancereport.list',
                ]
            ],
            [
                'group_name' => 'Role Permission',
                'permissions' => [
                    'assignrole.add',
                    'assignrole.edit',
                    'assignrole.list',
                    'assignrole.delete',
                    'role.add',
                    'role.edit',
                    'role.list',
                    'role.delete',
                    'permission.add',
                    'permission.edit',
                    'permission.list',
                    'permission.delete',
                ]
            ],
        ];

        $roleSuperAdmin = Role::create([
            'name' => 'Super-Admin',
            'guard_name' => 'web'
            ]);

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
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        // Assign super admin role permission to superadmin user
        $supperAdminusers = User::where('user_type', 'Super-Admin')->get();
        if ($supperAdminusers) {
            foreach ($supperAdminusers as $supperAdmin) {
                $supperAdmin->assignRole($roleSuperAdmin);
            }
        }

        
        // its for Admin Permissions  and role  start 
        $admin_permissions = [
            [
                'group_name' => 'Classes',
                'permissions' => [
                    'classes.add',
                    'classes.edit',
                    'classes.list',
                    'classes.delete',
                ]
            ],
            [
                'group_name' => 'Class Schedule',
                'permissions' => [
                    'class_schedule.add',
                    'class_schedule.edit',
                    'class_schedule.list',
                    'class_schedule.delete',
                ]
            ],
            [
                'group_name' => 'Quiz',
                'permissions' => [
                    'quiz.add',
                    'quiz.edit',
                    'quiz.list',
                    'quiz.delete',
                ]
            ],
            [
                'group_name' => 'Courses',
                'permissions' => [
                    'courses.add',
                    'courses.edit',
                    'courses.list',
                    'courses.delete',
                    'course_track.add',
                    'course_track.edit',
                    'course_track.list',
                    'course_track.delete',
                    'course_level.add',
                    'course_level.edit',
                    'course_level.list',
                    'course_level.delete',
                ]
            ],
            [
                'group_name' => 'Projects',
                'permissions' => [
                    'projects.add',
                    'projects.edit',
                    'projects.list',
                    'projects.delete',
                ]
            ],
            [
                'group_name' => 'Project Assesment',
                'permissions' => [
                    'projectassesment.add',
                    'projectassesment.edit',
                    'projectassesment.list',
                    'projectassesment.delete',
                ]
            ],
            [
                'group_name' => 'Trial Class',
                'permissions' => [
                    'trial_class.add',
                    'trial_class.edit',
                    'trial_class.list',
                    'trial_class.delete',
                    'trialclass_schedule.add',
                    'trialclass_schedule.edit',
                    'trialclass_schedule.list',
                    'trialclass_schedule.delete',
                ]
            ],
            [
                'group_name' => 'Users',
                'permissions' => [
                    'students.add',
                    'students.edit',
                    'students.list',
                    'students.delete',
                    'graduated_student.list',
                    'terminated_student.list',
                    'parents.add',
                    'parents.edit',
                    'parents.list',
                    'parents.delete',
                    'users.add',
                    'users.edit',
                    'users.list',
                    'users.delete',
                ]
            ],
            [
                'group_name' => 'Report',
                'permissions' => [
                    'attendance_report.list',
                    'comprehensive_report.list',
                ]
            ],
            [
                'group_name' => 'Payments',
                'permissions' => [
                    'payment.add',
                    'payment.edit',
                    'payment.list',
                    'payment.delete',
                ]
            ],
        ];

        $roleAdmin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web'
            ]);

        // Create and Assign Permissions
        for ($i = 0; $i < count($admin_permissions); $i++) {
            $permissionGroup = $admin_permissions[$i]['group_name'];
            for ($j = 0; $j < count($admin_permissions[$i]['permissions']); $j++) {
                // Create Permission
                $adminPermission = Permission::where([
                    'name' => $admin_permissions[$i]['permissions'][$j]
                    ])->first(); 
                if($adminPermission){
                   
                    $roleAdmin->givePermissionTo($adminPermission);
                    $adminPermission->assignRole($roleAdmin);   
                } 
            }
        }

        // Assign admin role permission to superadmin user
        $adminusers = User::where('user_type', 'Admin')->get();
        if ($adminusers) {
            foreach ($adminusers as $adminUser) {
                $adminUser->assignRole($roleAdmin);
            }
        }
        // close Admin Permission and role 

         // --------------------
        // its for Teacher Permissions  and role  start 
        $teacher_permissions = [
            [
                'group_name' => 'Attendance',
                'permissions' => [
                    'attendance.add',
                    'attendance.edit',
                    'attendance.list',
                    'attendance.delete',
                ]
            ],
            [
                'group_name' => 'Project Assesment',
                'permissions' => [
                    'projectassesment.add',
                    'projectassesment.edit',
                    'projectassesment.list',
                    'projectassesment.delete',
                ]
            ],
            [
                'group_name' => 'Trial Class',
                'permissions' => [
                    'trial_class.add',
                    'trial_class.edit',
                    'trial_class.list',
                    'trial_class.delete',
                    'trialclass_schedule.add',
                    'trialclass_schedule.edit',
                    'trialclass_schedule.list',
                    'trialclass_schedule.delete',
                ]
            ],
        ];

        $roleTeacher = Role::create([
            'name' => 'Teacher',
            'guard_name' => 'web'
            ]);

        // Create and Assign Permissions
        for ($i = 0; $i < count($teacher_permissions); $i++) {
            $permissionGroup = $teacher_permissions[$i]['group_name'];
            for ($j = 0; $j < count($teacher_permissions[$i]['permissions']); $j++) {
                // Create Permission
                $teacherPermission = Permission::where([
                    'name' => $teacher_permissions[$i]['permissions'][$j]
                    ])->first(); 
                if($teacherPermission){                   
                    $roleTeacher->givePermissionTo($teacherPermission);
                    $teacherPermission->assignRole($roleTeacher);   
                } 
            }
        }

        // Assign teacher role permission to superadmin user
        $teacherUsers = User::where('user_type', 'Teacher')->get();
        if ($teacherUsers) {
            foreach ($teacherUsers as $teacherUser) {
                $teacherUser->assignRole($roleTeacher);
            }
        }
        // close Teacher Role & Permission 
        // --------------------
        // its for Parent Permissions  and role  start 
        $parent_permissions = [
              [
                'group_name' => 'Payments',
                'permissions' => [
                    'payment.add',
                    'payment.edit',
                    'payment.list',
                    'payment.delete',
                ]
            ], 
            [
                'group_name' => 'Attendance',
                'permissions' => [
                    'attendancereport.list',
                ]
            ],
        ];

        $roleParent = Role::create([
            'name' => 'Parent',
            'guard_name' => 'web'
            ]);

        // Create and Assign Permissions
        for ($i = 0; $i < count($parent_permissions); $i++) {
            $permissionGroup = $parent_permissions[$i]['group_name'];
            for ($j = 0; $j < count($parent_permissions[$i]['permissions']); $j++) {
                // Create Permission
                $parentPermission = Permission::where([
                    'name' => $parent_permissions[$i]['permissions'][$j]
                    ])->first(); 
                if($parentPermission){                   
                    $roleParent->givePermissionTo($parentPermission);
                    $parentPermission->assignRole($roleParent);   
                } 
            }
        }
         // Assign parent role permission to superadmin user
        $parentUsers = User::where('user_type', 'Parent')->get();
        if ($parentUsers) {
            foreach ($parentUsers as $parentUser) {
                $parentUser->assignRole($roleParent);
            }
        }
        // close Parent Role & Permission 
         // --------------------
        // its for Student Permissions  and role  start 
        $student_permissions = [
               [
                'group_name' => 'Courses',
                'permissions' => [
                    'codingforkids.list',
                ]
            ],
        ];

        $roleStudent = Role::create([
            'name' => 'Student',
            'guard_name' => 'web'
            ]);

        // Create and Assign Permissions
        for ($i = 0; $i < count($student_permissions); $i++) {
            $permissionGroup = $student_permissions[$i]['group_name'];
            for ($j = 0; $j < count($student_permissions[$i]['permissions']); $j++) {
                // Create Permission
                $studentPermission = Permission::where([
                    'name' => $student_permissions[$i]['permissions'][$j]
                    ])->first(); 
                if($studentPermission){                   
                    $roleStudent->givePermissionTo($studentPermission);
                    $studentPermission->assignRole($roleStudent);   
                } 
            }
        }
         // Assign student role permission to superadmin user
        $studentUsers = User::where('user_type', 'Student')->get();
        if ($studentUsers) {
            foreach ($studentUsers as $studentUser) {
                $studentUser->assignRole($roleStudent);
            }
        }
        // close Parent Role & Permission 
    }

}
