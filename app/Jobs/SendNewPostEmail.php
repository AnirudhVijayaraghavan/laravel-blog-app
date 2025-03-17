<?php

namespace App\Jobs;

use App\Mail\NewPostMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewPostEmail implements ShouldQueue
{
    use Queueable;
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->data['sendTo'])->send(new NewPostMail([
            'name' => $this->data['name'],
            'title' => $this->data['title']
        ]));
    }
}
