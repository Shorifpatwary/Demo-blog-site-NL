<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateResource\Pages;
use App\Filament\Resources\StateResource\RelationManagers;
use App\Filament\Resources\StateResource\Widgets\StatsOverview;
use App\Models\Country;
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

class StateResource extends Resource
{
	protected static ?string $model = State::class;

	protected static ?string $navigationGroup = 'System Managment';

	protected static ?string $navigationIcon = 'heroicon-o-cake';
	protected static ?int $navigationSort = 2;

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Card::make()->schema([
					Select::make('country_id')->relationship('country', 'name')->required(),
					TextInput::make('name')->minLength(2)->maxLength(35)->required()
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
				TextColumn::make('country.name')->sortable()->searchable(),
				TextColumn::make('created_at')->dateTime()->sortable(),
			])
			->filters([
				// filter by country
				SelectFilter::make('country')->multiple()->relationship('country', 'name'),
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

	public static function getWidgets(): array
	{
		return [
			StatsOverview::class,
		];
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListStates::route('/'),
			'create' => Pages\CreateState::route('/create'),
			'edit' => Pages\EditState::route('/{record}/edit'),
		];
	}
}
