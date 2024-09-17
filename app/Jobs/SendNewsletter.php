<?php

namespace App\Jobs;

use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $contact;
    public $newsletter;

    /**
     * Create a new job instance.
     */
    public function __construct(string $contact, $newsletter)
    {
        $this->contact = $contact;
        $this->newsletter = $newsletter;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Send the newsletter email to the contact
        Mail::to($this->contact)->send(new NewsletterMail($this->contact, $this->newsletter));
    }
}
