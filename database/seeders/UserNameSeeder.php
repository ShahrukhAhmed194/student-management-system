<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach($users as $user){
            if(empty($user->user_name)){
                $name = strtolower($user->name);
                $trimed_name = preg_replace("/[$&+,:;=?@#|'<>.-^*()%!]/s",'',$name);
                $user_name = str_replace(" ", "-", $trimed_name);
                $user->user_name = $user_name.rand('0001', '9999');
                $user->save();
            }
            
        }
        
    }
}
