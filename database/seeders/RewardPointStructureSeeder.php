<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RewardPointsStructure;

class RewardPointStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RewardPointsStructure::create([
            'type' => 'ATTENDANCE_PRESENT',
            'points' => '10',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        RewardPointsStructure::create([
            'type' => 'ATTENDANCE_ABSENT',
            'points' => '0',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        RewardPointsStructure::create([
            'type' => 'DID_NOT_START',
            'points' => '0',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        RewardPointsStructure::create([
            'type' => 'IN_PROGRESS',
            'points' => '4',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        RewardPointsStructure::create([
            'type' => 'COMPLETE',
            'points' => '10',
            'created_at' => date('Y-m-d H:i:s'),
        ]); 
        RewardPointsStructure::create([
            'type' => 'BELOW_AVERAGE',
            'points' => '2',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        RewardPointsStructure::create([
            'type' => 'AVERAGE',
            'points' => '5',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        RewardPointsStructure::create([
            'type' => 'GOOD',
            'points' => '7',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        RewardPointsStructure::create([
            'type' => 'EXCELLENT',
            'points' => '10',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
