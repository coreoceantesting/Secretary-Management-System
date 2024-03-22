<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\RescheduleMeetingMail;

class RescheduleMeetingEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $email;
    protected $oldData;
    protected $newData;

    public function __construct($email, $oldData, $newData)
    {
        $this->email = $email;
        $this->oldData = $oldData;
        $this->newData = $newData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new RescheduleMeetingMail($this->oldData, $this->newData));
    }
}
