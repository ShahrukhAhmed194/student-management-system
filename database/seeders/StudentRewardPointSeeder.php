<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentAttendance;
use App\Models\StudentRewardPoint;
use App\Models\RewardPointsStructure;

class StudentRewardPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$from = date('2023-03-01');
		$to = date('2023-04-30');

		$marchAprilAttendanceStudent = StudentAttendance::whereBetween('date', [$from, $to])->get();
		if($marchAprilAttendanceStudent){
			// ----------------- its for student reward point -------------
			foreach ($marchAprilAttendanceStudent as $single) {
	            $points = $existsRewardPoint = 0;
				$student_id = $single->student_id;
				$presentAbsent = $single->status;
				
	            $existsRewardInfo = StudentRewardPoint::where('student_id', $student_id)->first();
	            if($existsRewardInfo){
	                $existsRewardPoint = $existsRewardInfo->points;   
	            }
	            if($presentAbsent == 1){
	              $presentPoint = RewardPointsStructure::where('type', 'ATTENDANCE_PRESENT')->first();
	                $points = ($existsRewardPoint+$presentPoint->points);
	            }elseif($presentAbsent == 0){
	              $absentPoint = RewardPointsStructure::where('type', 'ATTENDANCE_ABSENT')->first();
	                $points = ($existsRewardPoint+$absentPoint->points);
	            }

	            if($existsRewardInfo){
	                $rewardData = StudentRewardPoint::where("student_id", $student_id)->update([
	                    "points" => $points,
	                ]); 
	            }else{
	                $rewardData = StudentRewardPoint::create([
	                    "student_id" => $student_id,
	                    "points" => $points,
	                ]);
	            }
			}
		}
        // ----------------- its for student reward point -------------
    }
}
