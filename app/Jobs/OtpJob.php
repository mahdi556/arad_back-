<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\OtpSms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OtpJob implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
     
    public $OTPCode;
    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($OTPCode,User $user)
    {
        $this->OTPCode=$OTPCode;
        $this->user=$user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       $this->user->notify(new OtpSms($this->OTPCode, $this->user->cellphone));
    }
}
