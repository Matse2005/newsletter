<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class EmailSetting extends Settings
{
    public string $logo;

    public string $primary;

    public static function group(): string
    {
        return 'email';
    }
}
