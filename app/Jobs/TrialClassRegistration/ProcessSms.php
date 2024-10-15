<?php

namespace App\Jobs\TrialClassRegistration;

use App\Traits\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private $phone,
        private $smsMessage
    )
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->SMSNotification($this->phone, $this->smsMessage);
    }
}
