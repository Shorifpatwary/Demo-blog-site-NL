<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class CityResource extends Resource
{
	protected static ?string $model = City::class;
	protected static ?string $navigationGroup = 'System Managment';
	protected static ?string $navigationIcon = 'heroicon-o-office-building';
	protected static ?int $navigationSort = 3;

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Card::make()
					->schema([
						// ->exists(table: State::class)
						Select::make('state_id')
							->relationship('state', 'name')->required(),
						TextInput::make('name')->minLength(2)->maxLength(30)->required()->unique(ignoreRecord: true)
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
				TextColumn::make('state.name')->sortable()->searchable(),
				TextColumn::make('created_at')->dateTime()->sortable(),
			])
			->filters([
				// filter by state
				SelectFilter::make('state')->multiple()->relationship('state', 'name'),
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
			'index' => Pages\ListCities::route('/'),
			'create' => Pages\CreateCity::route('/create'),
			'edit' => Pages\EditCity::route('/{record}/edit'),
		];
	}
}
