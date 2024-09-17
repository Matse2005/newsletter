<?php

namespace App\Filament\Pages;

use App\Settings\EmailSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageEmail extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-code-bracket-square';

    protected static string $settings = EmailSetting::class;

    protected static ?string $navigationGroup = 'Instellingen';

    protected static ?string $title = 'E-mail Ontwerp';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('logo')
                    ->columnSpanFull(),
            ]);
    }
}
