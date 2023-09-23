<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;

class ThrottledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 15,
        $timeout = 10;

    public $mail, $user;

    /**
     * Create a new job instance.
     */
    public function __construct(Mailable $mail, User $user)
    {
        $this->mail=$mail;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Redis::throttle('mailtrap')->allow(2)->every(12)->then(function () {
            Mail::to($this->user)->send($this->mail);
        }, function () {
            return $this->release(5);
        });
    }
}
