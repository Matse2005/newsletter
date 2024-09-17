<?php

namespace App\Filament\Pages;

use App\Settings\PrestashopSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManagePrestashop extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string $settings = PrestashopSettings::class;

    protected static ?string $navigationGroup = 'Instellingen';

    protected static ?string $title = 'Prestashop';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->required(),
                Forms\Components\TextInput::make('key')
                    ->label('Webservice Sleutel')
                    ->required(),
            ]);
    }
}
