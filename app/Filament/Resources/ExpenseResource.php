<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Category;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-m-arrow-trending-down';

    protected static ?string $navigationGroup = 'Configurations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('amount')
                    ->numeric()
                    ->required(),
                Textarea::make('description')
                    ->columnSpan(2),
                DateTimePicker::make('date')
                    ->default(now())
                    ->required()
                    ->readOnly(fn(Get $get) => $get('type') === Expense::TYPE_REGULAR),
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('title', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Radio::make('type')
                    ->label("What's the type?")
                    ->options([
                        Expense::TYPE_PROGRAMMED => 'Programmed',
                        Expense::TYPE_REGULAR => 'Regular',
                    ])
                    ->default(Expense::TYPE_REGULAR)
                    ->reactive()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('amount')
                    ->prefix('S/.')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        Expense::TYPE_PROGRAMMED => 'Programmed',
                        Expense::TYPE_REGULAR => 'Regular',
                    })
                    ->color('success'),
                TextColumn::make('category.title'),
                TextColumn::make('date')
                    ->icon('heroicon-o-calendar'),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
