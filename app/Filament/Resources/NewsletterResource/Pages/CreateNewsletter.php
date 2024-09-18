<?php

namespace App\Filament\Resources\NewsletterResource\Pages;

use App\Filament\Resources\NewsletterResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateNewsletter extends CreateRecord
{
    protected static string $resource = NewsletterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('bestanden')
                // ->action(fn (Contract $record) => $record->advance())
                ->icon('heroicon-o-document-text')
                ->modalContent(fn() => view(
                    'files',
                ))
                ->modalSubmitAction(false)
                ->slideOver(),
        ];
    }
}
