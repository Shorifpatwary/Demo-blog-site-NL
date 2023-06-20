<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationGroup = 'User Managment';

  protected static ?string $navigationIcon = 'heroicon-o-user-group';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Card::make()
          ->schema([
            // name input
            TextInput::make('name')->minLength(2)->maxLength(40)->required(),
            // email
            TextInput::make('email')->email()->unique(ignoreRecord: true)->minLength(2)->maxLength(60)->required(),
            // password
            TextInput::make('password')->password()
              ->minLength(8)
              ->maxLength(12)
              ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
              ->hidden(fn (Page $livewire): bool => $livewire instanceof EditRecord)
              ->same('confirmpassword')
              ->dehydrated(fn ($state) => filled($state))
              ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
            // confirm password
            TextInput::make('confirmpassword')->password()->minLength(8)->maxLength(12)
              ->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord)
              ->hidden(fn (Page $livewire): bool => $livewire instanceof EditRecord)
              ->dehydrated(false),
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
        TextColumn::make('name')->sortable()->searchable(),
        TextColumn::make('email')->sortable()->searchable(),
        TextColumn::make('created_at')->sortable(),
      ])
      ->filters([
        TernaryFilter::make('email_verified_at')->nullable(),
        Filter::make('created_at')
          ->form([
            Forms\Components\DatePicker::make('created_from'),
            Forms\Components\DatePicker::make('created_until'),
          ])
          ->query(function (Builder $query, array $data): Builder {
            return $query
              ->when(
                $data['created_from'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
              )
              ->when(
                $data['created_until'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
              );
          })
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
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUser::route('/create'),
      'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }
}
