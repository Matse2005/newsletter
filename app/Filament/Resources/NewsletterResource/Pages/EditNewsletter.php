<?php

namespace App\Filament\Resources\NewsletterResource\Pages;

use App\Filament\Resources\NewsletterResource;
use App\Http\Controllers\NewsletterController;
use App\Models\Newsletter;
use Carbon\CarbonInterval;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditNewsletter extends EditRecord
{
    protected static string $resource = NewsletterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Action::make('sendEmail') // Custom action
            //     ->label('Verstuur')
            //     ->icon('heroicon-o-paper-airplane')
            //     ->requiresConfirmation() // Show a confirmation modal
            //     ->modalHeading('Verstuur Nieuwsbrief')
            //     ->modalDescription('Ben je klaar om deze nieuwsbrief te versturen?')
            //     ->modalSubmitActionLabel('Ja, versturen!') // Positive modal button
            //     ->modalIcon('heroicon-o-paper-airplane')
            //     ->action(function ($record) {
            //         $amount = NewsletterController::send($record);
            //         Notification::make()
            //             ->title('Nieuwsbrief is verstuurd en zal geleidelijk aan bij de contacten terecht komen.')
            //             ->success()
            //             ->send();
            //         $duration = ($amount - 1) * 30;
            //         Notification::make()
            //             ->title('Het zal ' . CarbonInterval::seconds($duration)->cascade()->forHumans() . ' duren tot dat alle nieuwsbrieven verzonden zijn.')
            //             ->success()
            //             ->seconds(30)
            //             ->send();
            //     }),
            Action::make('bestanden')
                // ->action(fn (Contract $record) => $record->advance())
                ->icon('heroicon-o-document-text')
                ->modalContent(fn() => view(
                    'files',
                ))
                ->modalSubmitAction(false)
                ->slideOver(),
            Action::make('duplicate')
                ->label('Dupliceren')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (Newsletter $record) {
                    // Duplicate the record
                    $newNewsletter = $record->replicate(); // Copy the current record
                    $newNewsletter->send_at = null;
                    $newNewsletter->save(); // Save the new duplicate

                    // Redirect to the edit page of the newly duplicated newsletter
                    redirect(route('filament.newsletter.resources.newsletters.edit', $newNewsletter));
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
