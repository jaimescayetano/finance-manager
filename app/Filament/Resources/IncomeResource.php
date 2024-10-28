<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Filament\Resources\IncomeResource\RelationManagers;
use App\Models\Income;
use App\Models\IncomeSource;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrow-trending-up';

    protected static ?string $navigationGroup = 'Configurations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->columnSpan(2),
                Textarea::make('description')
                    ->columnSpan(2),
                DateTimePicker::make('date')
                    ->default(now())
                    ->required()
                    ->readOnly(),
                Select::make('income_source_id')
                    ->label('Income source')
                    ->relationship(name: 'incomeSource', titleAttribute: 'title')
                    ->createOptionForm([
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),
                        Hidden::make('user_id')
                            ->default(auth()->id())
                    ])
                    ->preload()
                    ->searchable()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('incomeSource.title')
                    ->searchable(),
                TextColumn::make('amount')
                    ->prefix('S/.')
                    ->searchable(),
                TextColumn::make('date')
                    ->icon('heroicon-o-calendar'),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
