<?php

namespace App\Jobs\TrialClassRegistration;

use App\Traits\WhatsAppNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WhatsAppNotification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private $phone,
        private $whatsAppMessage
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
        $this->sendWANotificationSecond($this->phone, $this->whatsAppMessage);
    }
}
