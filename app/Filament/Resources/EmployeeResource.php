<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class EmployeeResource extends Resource
{
  protected static ?string $model = Employee::class;

  protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Card::make()
          ->schema([
            // first name
            TextInput::make('first_name')->minLength(2)->maxLength(35)->required(),
            // last name
            TextInput::make('last_name')->minLength(2)->maxLength(35),
            // address
            TextInput::make('address')->minLength(2)->maxLength(150),
            // select country
            Select::make('country_id')
              ->options(Country::all()->pluck('name', 'id')->toArray())
              ->reactive()
              ->afterStateUpdated(function (Closure $set) {
                $set('state_id', null);
              })
              ->required(),
            // select state
            Select::make('state_id')->label('Select State')->options(function (callable $get) {
              $country = Country::find($get('country_id'));
              if (!$country) {
                return State::all()->pluck('name', 'id');
              } else {
                return $country->state->pluck('name', 'id');
              }
            })->reactive()
              ->afterStateUpdated(function (Closure $set) {
                $set('city_id', null);
              })->required(),
            // select city
            Select::make('city_id')
              ->options(function (callable $get) {
                $state = State::find($get('state_id'));
                if (!$state) {
                  return City::all()->pluck('name', 'id');
                }
                return $state->city->pluck('name', 'id');
              })
              ->reactive()
              ->required(),
            // select department
            Select::make('department_id')->relationship('department', 'name')->required(),
            // zip code
            TextInput::make('zip_code')->minLength(2)->maxLength(25),
            // birth date
            DatePicker::make('birth_date')->required(),
            // date hired
            DatePicker::make('date_hired')->required(),
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('Index No')->getStateUsing(
          static function (stdClass $rowLoop, HasTable $livewire): string {
            return (string) ($rowLoop->iteration +
              ($livewire->tableRecordsPerPage * ($livewire->page - 1
              ))
            );
          }
        ),
        TextColumn::make('first_name')->sortable()->searchable(),
        TextColumn::make('last_name')->sortable()->searchable(),
        TextColumn::make('address')->sortable()->searchable(),
        TextColumn::make('country.name')->sortable()->searchable(),
        TextColumn::make('state.name')->sortable()->searchable(),
        TextColumn::make('city.name')->sortable()->searchable(),
        TextColumn::make('department.name')->sortable()->searchable(),
        TextColumn::make('zip_code')->sortable(),
        TextColumn::make('birth_date')->dateTime()->sortable(),
        TextColumn::make('date_hired')->dateTime()->sortable(),
        TextColumn::make('created_at')->dateTime()->sortable(),
      ])
      ->filters([
        // filter by country
        SelectFilter::make('country')->multiple()->relationship('country', 'name'),
        // filter by state
        SelectFilter::make('state')->multiple()->relationship('state', 'name'),
        // filter by city
        SelectFilter::make('city')->multiple()->relationship('city', 'name'),
        // filter by department
        SelectFilter::make('department')->multiple()->relationship('department', 'name'),
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

  // public static function getWidgets(): array
  // {
  //   return [
  //     StatsOverview::class,
  //   ];
  // }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListEmployees::route('/'),
      'create' => Pages\CreateEmployee::route('/create'),
      'edit' => Pages\EditEmployee::route('/{record}/edit'),
    ];
  }
}