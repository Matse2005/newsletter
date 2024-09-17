<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = PrestashopController::customerIDByEmail($request->email);
        $customer = PrestashopController::customerByIDInXML($id);

        PrestashopController::subscribe($id, $customer);

        if ($request->lang) {
            $language = Language::where('key', $request->lang)->first();
            if (!$language)
                $language = Language::where('key', 'default')->first();
        } else {
            $language = Language::where('key', 'default')->first();
        }

        return view('subscribe', ['email' => $request->email, 'language' => $language]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = PrestashopController::customerIDByEmail($request->email);
        $customer = PrestashopController::customerByIDInXML($id);

        PrestashopController::unsubscribe($id, $customer);

        if ($request->lang) {
            $language = Language::where('key', $request->lang)->first();
            if (!$language)
                $language = Language::where('key', 'default')->first();
        } else {
            $language = Language::where('key', 'default')->first();
        }

        return view('unsubscribe', ['email' => $request->email, 'language' => $language]);
    }
}
