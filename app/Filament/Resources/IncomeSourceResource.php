<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeSourceResource\Pages;
use App\Filament\Resources\IncomeSourceResource\RelationManagers;
use App\Models\IncomeSource;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class IncomeSourceResource extends Resource
{
    protected static ?string $model = IncomeSource::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Configurations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                TextInput::make('icon_svg')
                    ->label('Icon'),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpan(2)
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                IconColumn::make('icon_svg')
                    ->label('Icon')
                    ->icon(function(string $state) {
                        // Validate if icon exists
                        try {
                            svg($state);
                            return $state;
                        } catch (\Throwable $th) {
                            return null;
                        }
                    })
                    ->color('success')
                    ->size(IconColumn\IconColumnSize::Medium),
                TextColumn::make('created_at')
                    ->label('Created at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListIncomeSources::route('/'),
            'create' => Pages\CreateIncomeSource::route('/create'),
            'edit' => Pages\EditIncomeSource::route('/{record}/edit'),
        ];
    }
}
