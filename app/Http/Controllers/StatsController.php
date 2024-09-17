<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatsController extends Controller
{
    public function link(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link' => 'required|url',
        ]);

        if ($validator->fails()) {
            abort(404);
        }
        $link = $request->link;
        $foundLink = Link::where('link', $link)->first();
        if (!$foundLink) {
            $foundLink = Link::create([
                'link' => $link
            ]);
        }

        $foundLink->update([
            "clicked" => $foundLink->clicked + 1
        ]);

        return redirect()->away($link . '?utm_source=newsletter&utm_medium=email');
    }
}
