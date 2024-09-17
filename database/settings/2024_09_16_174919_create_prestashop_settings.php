<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('prestashop.url', '');
        $this->migrator->add('prestashop.key', '');
    }
};
