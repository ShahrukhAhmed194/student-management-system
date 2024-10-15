<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{SalesUser, User};

class createSalesUserKasem extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'kajem.dreamers@gmail.com')->where('user_type', 'Admin')->first();

        SalesUser::create([
            'user_id' => $user->id,
            'mobile' => '+8801897717791',
            'available' => '1',
        ]);
    }
}
