<?php

namespace App\Filament\Resources\GroupResource\Pages;

use App\Filament\Resources\GroupResource;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('uploadEmails')
                ->label('E-mails toevoegen')
                ->form([
                    FileUpload::make('email_file')
                        ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                        ->disk('public') // Save the file to the public disk
                        ->directory('uploads')
                        ->required()
                        ->label('Upload een CSV, Excel, of TXT bestand met e-mails.'),
                ])
                ->requiresConfirmation() // This will add a confirmation modal
                ->modalDescription('Weet je zeker dat je dit wilt doen? De huidige e-mails zullen overschreven worden.')
                ->action(function (array $data) {
                    $filePath = $data['email_file']; // File is already stored at this path
                    $emails = [];

                    // Process the file based on its type
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION); // Get file extension
                    if (in_array($extension, ['csv', 'txt'])) {
                        $content = File::get(storage_path('app/public/' . $filePath));
                        $emails = explode(PHP_EOL, $content); // Split by new line
                    } elseif (in_array($extension, ['xls', 'xlsx'])) {
                        $emails = Excel::toCollection(null, storage_path('app/public/' . $filePath))->flatten()->toArray();
                    }

                    File::delete(storage_path('app/public/' . $filePath));

                    // Overwrite the current emails (e.g., update in the database)
                    // Assuming there's a 'emails' column in your Group model:
                    $this->record->emails = implode(PHP_EOL, array_filter($emails)); // Join emails with newline
                    $this->record->save();

                    // Notify the user of success
                    Notification::make()
                        ->title('Emails Uploaded')
                        ->body('The emails have been successfully overwritten.')
                        ->success()
                        ->send();

                    return redirect()->route('filament.newsletter.resources.groups.edit', $this->record->getKey());
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
