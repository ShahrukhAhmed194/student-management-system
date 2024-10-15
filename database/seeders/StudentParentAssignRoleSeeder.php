<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class StudentParentAssignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parentRole = Role::where('name', 'Parent')->first();
        $parents = User::where('user_type', User::USER_TYPE_PARENT)->get();
        foreach ($parents as $parent) {
            if (!$parent->hasRole('Parent')) {
                $parent->assignRole($parentRole);
            }
        }
        
        $studentRole = Role::where('name', 'Student')->first();
        $students = User::where('user_type', User::USER_TYPE_STUDENT)->get();
        foreach ($students as $student) {
            if (!$student->hasRole('Student')) {
                $student->assignRole($studentRole);
            }
        }
    }
}
