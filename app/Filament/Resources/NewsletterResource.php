<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterResource\Pages;
use App\Filament\Resources\NewsletterResource\RelationManagers;
use App\Http\Controllers\NewsletterController;
use App\Models\Newsletter;
use App\Models\Group;
use App\Models\Language;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class NewsletterResource extends Resource
{
    protected static ?string $model = Newsletter::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static ?string $navigationGroup = 'Nieuwsbrieven';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->options(Language::whereNot('key', 'default')->pluck('title', 'id'))
                    ->required()
                    ->native(false),
                Forms\Components\Select::make('group_id')
                    ->options(Group::all()->pluck('group', 'id'))
                    ->required()
                    ->native(false),
                TiptapEditor::make('email')
                    ->profile('default')
                    // ->tools([]) // individual tools to use in the editor, overwrites profile
                    // ->disk('string') // optional, defaults to config setting
                    // ->directory('string or Closure returning a string') // optional, defaults to config setting
                    // ->acceptedFileTypes(['array of file types']) // optional, defaults to config setting
                    // ->maxSize('integer in KB') // optional, defaults to config setting
                    ->output(TiptapOutput::Html) // optional, change the format for saved data, default is html
                    ->maxContentWidth('5xl')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('language.title')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(
                        fn(string $state): string => match ($state) {
                            'Default' => 'danger',
                            default => 'success', // Optional: a default color in case no match is found
                        }
                    ),
                Tables\Columns\TextColumn::make('group.group')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(function ($record): string {
                        return match ($record->group->manual) {
                            1 => 'info',
                            0 => 'warning',
                            default => 'secondary', // Optional: a default color in case no match is found
                        };
                    }),
                Tables\Columns\TextColumn::make('send_at')
                    ->label('Verstuurd')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->send_at ? 'verzonden' : 'niet verzonden';
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'verzonden' => 'success',
                        'niet verzonden' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('sendEmail') // Custom action
                    // ->label('Verstuur')
                    ->icon('heroicon-o-paper-airplane')
                    ->tooltip('Versturen')
                    ->iconButton()
                    ->requiresConfirmation() // Show a confirmation modal
                    ->modalHeading('Verstuur Nieuwsbrief')
                    ->modalDescription('Ben je klaar om deze nieuwsbrief te versturen?')
                    ->modalSubmitActionLabel('Ja, versturen!') // Positive modal button
                    ->modalIcon('heroicon-o-paper-airplane')
                    ->action(function ($record) {
                        $amount = NewsletterController::send($record);
                        Notification::make()
                            ->title('Nieuwsbrief is verstuurd en zal geleidelijk aan bij de contacten terecht komen.')
                            ->success()
                            ->send();
                        $duration = ($amount - 1) * 30;
                        Notification::make()
                            ->title('Het zal ' . CarbonInterval::seconds($duration)->cascade()->forHumans() . ' duren tot dat alle nieuwsbrieven verzonden zijn.')
                            ->success()
                            ->seconds(30)
                            ->send();
                    }),
                Tables\Actions\Action::make('viewNewsletter') // New custom action for viewing a newsletter
                    ->icon('heroicon-o-eye')
                    ->tooltip('Nieuwsbrief Bekijken')
                    ->iconButton()
                    ->url(function ($record) {
                        return route('newsletter', $record); // Assuming you have a route set up to view the newsletter
                    })
                    ->openUrlInNewTab(), // Ensures the action opens the URL in a new tab
                Tables\Actions\EditAction::make()
                    ->tooltip('Bewerken')
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsletters::route('/'),
            'create' => Pages\CreateNewsletter::route('/create'),
            'edit' => Pages\EditNewsletter::route('/{record}/edit'),
        ];
    }
}
