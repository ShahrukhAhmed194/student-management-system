<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TrialClass;
use App\Models\NoteUpdateHistory;

class UpdateNoteHistory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trial_classes = TrialClass::whereNotNull('note')->get();
        $super_admin = User::where('email', 'admin@gmail.com')->first();

        foreach($trial_classes as $trial_class){
            $note_history = new NoteUpdateHistory();
            $note_history->trial_class_id = $trial_class->id;
            $note_history->note = $trial_class->note;
            $note_history->user_id = $super_admin->id;
            $note_history->save();
        }
    }
}
