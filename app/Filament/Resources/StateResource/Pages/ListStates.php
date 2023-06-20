<?php

namespace App\Filament\Resources\StateResource\Pages;

use App\Filament\Resources\StateResource;
use App\Filament\Resources\StateResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStates extends ListRecords
{
	protected static string $resource = StateResource::class;

	protected function getActions(): array
	{
		return [
			Actions\CreateAction::make(),
		];
	}
	// state overview widget 
	protected  function getHeaderWidgets(): array
	{
		return [
			StatsOverview::class,
		];
	}
}
