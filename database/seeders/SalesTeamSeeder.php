<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SalesUser;

class SalesTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emails = array(
            'shammi.dreamers@gmail.com',
            'mayesa.dreamers@gmail.com',
            'shifa.dreamers@gmail.com',
            'anikshahriar234@gmail.com'
        );
        $users = User::whereIn('email', $emails)->where('user_type', 'Admin')->get();

        foreach($users as $user){
            $mobile = '';
            if($user->email == $emails[0]){
                $mobile = '01897717782';
            }
            if($user->email == $emails[1]){
                $mobile = '01897717783';
            }
            if($user->email == $emails[2]){
                $mobile = '01602541531';
            }
            if($user->email == $emails[3]){
                $mobile = '01897717784';
            }
            
            SalesUser::create([
                'user_id' => $user->id,
                'mobile' => $mobile,
                'available' => '1',
            ]);
        }
    }
}
