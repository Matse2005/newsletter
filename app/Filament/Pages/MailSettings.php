<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class MailSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.mail-settings';

    protected static bool $shouldRegisterNavigation = false;

    public $MAIL_MAILER;
    public $MAIL_HOST;
    public $MAIL_PORT;
    public $MAIL_USERNAME;
    public $MAIL_PASSWORD;
    public $MAIL_ENCRYPTION;
    public $MAIL_FROM_ADDRESS;
    public $MAIL_FROM_NAME;

    public function mount(): void
    {
        // Load current .env mail settings into form state
        $this->form->fill($this->loadEnvValues());
    }

    protected function loadEnvValues(): array
    {
        return [
            'MAIL_MAILER' => env('MAIL_MAILER', 'smtp'),
            'MAIL_HOST' => env('MAIL_HOST', 'localhost'),
            'MAIL_PORT' => env('MAIL_PORT', 587),
            'MAIL_USERNAME' => env('MAIL_USERNAME', ''),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD', ''),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION', 'TLS'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS', 'noreply@example.com'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME', config('app.name')),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('MAIL_MAILER')
                ->label('Mail Mailer')
                ->required(),
            Forms\Components\TextInput::make('MAIL_HOST')
                ->label('Mail Host')
                ->required(),
            Forms\Components\TextInput::make('MAIL_PORT')
                ->label('Mail Port')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('MAIL_USERNAME')
                ->label('Mail Username')
                ->required(),
            Forms\Components\TextInput::make('MAIL_PASSWORD')
                ->label('Mail Password')
                ->password()
                ->revealable()
                ->required(),
            Forms\Components\TextInput::make('MAIL_ENCRYPTION')
                ->label('Mail Encryption')
                ->required(),
            Forms\Components\TextInput::make('MAIL_FROM_ADDRESS')
                ->label('Mail From Address')
                ->required(),
            Forms\Components\TextInput::make('MAIL_FROM_NAME')
                ->label('Mail From Name')
                ->required(),
        ];
    }

    public function save(): void
    {
        $this->validate();

        // Update .env file with the new mail settings
        $this->updateEnvFile($this->form->getState());

        // You might want to clear the config cache for the new changes to take effect
        Artisan::call('config:clear');

        session()->flash('success', 'Mail settings updated successfully!');
    }

    protected function updateEnvFile(array $data): void
    {
        $envFile = base_path('.env');
        $contents = File::get($envFile);
        $lines = explode("\n", $contents);

        foreach ($lines as &$line) {
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            $parts = explode('=', $line, 2);
            $key = $parts[0];

            if (isset($data[$key])) {
                $value = $data[$key];

                // If the value contains spaces, enclose it in double quotes
                if (preg_match('/\s/', $value)) {
                    $value = '"' . $value . '"';
                }

                $line = $key . '=' . $value;
                unset($data[$key]);
            }
        }

        foreach ($data as $key => $value) {
            // If the value contains spaces, enclose it in double quotes
            if (preg_match('/\s/', $value)) {
                $value = '"' . $value . '"';
            }

            $lines[] = $key . '=' . $value;
        }

        $updatedContents = implode("\n", $lines);
        File::put($envFile, $updatedContents);
    }
}
