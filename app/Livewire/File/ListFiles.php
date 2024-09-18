<?php

namespace App\Livewire\File;

use App\Models\File;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ListFiles extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(File::query())
            ->columns([
                Tables\Columns\TextColumn::make('original_name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_url')
                    ->label('File URL')
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        return config('app.url') . $record->file_url;
                    })
                    ->copyable()
                    ->copyMessage('URL gekopieerd naar clipboard')
                    ->copyMessageDuration(1500),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('make')
                ->label('Bestand toevoegen')
                ->action(fn() => redirect()->route('filament.newsletter.resources.files.create'))
        ];
    }

    public function render(): View
    {
        return view('livewire.file.list-files');
    }
}
