<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $this->call(RewardPointStructureSeeder::class);
        $this->call(RolePermissionRecordingSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(RolePermissionStudentStatusSeeder::class);
        $this->call(SalesTeamSeeder::class);
        $this->call(StudentPayDueDate::class);
        $this->call(StudentRewardPointSeeder::class);
        $this->call(StudentsClassNumberSeeder::class);
        $this->call(UpdateActivePaymentStatus::class);
        $this->call(UpdateNoteHistory::class);
        $this->call(UpdateStudentNotes::class);
        $this->call(UserIdForActionHistories::class);
        $this->call(UserNameSeeder::class);
    }
}
