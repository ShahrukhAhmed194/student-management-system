<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;

class SetDueGraceValueToZeorForAllStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:setDueGraceValueToZero';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This cron job runs everyday at 11.30 pm. This updates all the students due grace fields value to zero.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Student::query()->where('due_grace', 1 )->update(['due_grace' => 0]);

        return 0;
    }
}
