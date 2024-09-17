<?php

use App\Http\Controllers\StatsController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Newsletter;
use App\Settings\EmailSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/newsletter/{id}/{title?}', function (int $id) {
    return view('emails.newsletter', ['newsletter' => Newsletter::findOrFail($id)]);
})->name('newsletter');

Route::get('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe');

Route::get('/unsubscribe', [SubscriptionController::class, 'destroy'])->name('unsubscribe');

Route::get('/link', [StatsController::class, 'link'])->name('link');
