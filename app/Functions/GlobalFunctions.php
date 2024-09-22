<?php

use App\Settings\EmailSetting;

function format_email($email)
{
  $email = str_replace('data-as-button="true" data-as-button-theme="primary"', 'class="button button-primary"', $email);
  $email = str_replace('data-as-button="true""', 'class="button"', $email);
  $email = str_replace('href="', 'target="_blank" href="' . config('app.url') . '/link?link=', $email);

  return $email;
}

function settings()
{
  return app(EmailSetting::class);
}

function general_settings()
{
  return \Illuminate\Support\Facades\DB::table('general_settings')->first();
}
