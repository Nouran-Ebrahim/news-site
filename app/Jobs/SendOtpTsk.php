<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\SendOtpVirifyUserEmail;

class SendOtpTsk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $user;
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->notify(new SendOtpVirifyUserEmail('Email verification code.')); // other tasks no depend on this task so we can add it in the queu

    }
}
