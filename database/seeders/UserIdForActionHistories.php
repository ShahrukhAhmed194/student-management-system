<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusActionHistory;
use App\Models\User;

class UserIdForActionHistories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $action_histories = StatusActionHistory::all();
        $fixed_admin = User::where('email', 'admin@gmail.com')->first();
        foreach($action_histories as $action_history){
            if(empty($action_history->user_id)){
                $action_history->user_id = $fixed_admin->id;
                $action_history->save();
            }
        }
        
    }
}
