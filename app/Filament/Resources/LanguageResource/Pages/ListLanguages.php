<?php

namespace App\Filament\Resources\LanguageResource\Pages;

use App\Filament\Resources\LanguageResource;
use App\Models\Language;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLanguages extends ListRecords
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('new')
                ->label('Taal aanmaken')
                // ->icon('heroicon-o-document-duplicate')
                ->action(function () {
                    $record = Language::where('key', 'default')->first();
                    // Duplicate the record
                    $language = $record->replicate(); // Copy the current record
                    $language->key = "";
                    $language->title = "";
                    $language->local = "";
                    $language->save(); // Save the new duplicate

                    // Redirect to the edit page of the newly duplicated newsletter
                    redirect(route('filament.newsletter.resources.languages.edit', $language));
                }),
            // Actions\CreateAction::make(),
        ];
    }
}
