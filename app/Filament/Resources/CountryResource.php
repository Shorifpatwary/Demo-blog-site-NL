<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class CountryResource extends Resource
{
  protected static ?string $model = Country::class;

  protected static ?string $navigationGroup = 'System Managment';

  protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
  protected static ?int $navigationSort = 1;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Card::make()
          ->schema([
            TextInput::make('country_id')->minLength(2)->maxLength(5)->required(),
            TextInput::make('name')->minLength(2)->maxLength(40)->required(),
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('SL No')->getStateUsing(
          static function (stdClass $rowLoop, HasTable $livewire): string {
            return (string) ($rowLoop->iteration +
              ($livewire->tableRecordsPerPage * ($livewire->page - 1
              ))
            );
          }
        ),
        TextColumn::make('country_id')->sortable()->searchable(),
        TextColumn::make('name')->sortable()->searchable(),
        TextColumn::make('created_at')->dateTime()->sortable()
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\ViewAction::make(),
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\DeleteBulkAction::make(),
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
      'index' => Pages\ListCountries::route('/'),
      'create' => Pages\CreateCountry::route('/create'),
      'edit' => Pages\EditCountry::route('/{record}/edit'),
    ];
  }
}
