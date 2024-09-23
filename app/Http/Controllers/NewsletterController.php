<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewsletter;
use App\Models\Group;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public static function send(Newsletter $newsletter)
    {
        $contacts = NewsletterController::groups($newsletter->group);

        foreach ($contacts as $index => $contact) {
            // Dispatch a job to send the newsletter with a delay
            SendNewsletter::dispatch($contact, $newsletter)->delay(now()->addSeconds($index * 30));
        }

        // Optionally update the send_at timestamp or log the sending
        $newsletter->update(['send_at' => now()]);

        return count($contacts);
    }

    public static function groups($group)
    {
        Log::debug($group);
        if ($group)
            if ($group->manual == 0)
                return NewsletterController::contacts();
            else if ($group->emails !== null)
                return preg_split('/\n/', $group->emails);

        return [];
    }

    public static function contacts()
    {
        // return [
        //     "matse@vanhorebeek.be",
        //     "matse.vanhorebeek@gmail.com"
        // ];

        return PrestashopController::contacts();
    }
}
