<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PrestashopSettings extends Settings
{
    public string $url;

    public string $key;

    public static function group(): string
    {
        return 'prestashop';
    }
}
