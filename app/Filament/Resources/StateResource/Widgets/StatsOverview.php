<?php

namespace App\Filament\Resources\StateResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
	protected static ?string $pollingInterval = null;
	protected function getCards(): array
	{
		return [
			Card::make('Unique views', '192.1k')
				->description('32k increase')
				->descriptionIcon('heroicon-s-trending-up')
				->chart([7, 2, 10, 3, 15, 4, 34])
				->color('success'),
			Card::make('Bounce rate', '21%')
				->description('7% increase')
				->descriptionIcon('heroicon-s-trending-down')
				->color('danger'),
			Card::make('Average time on page', '3:12')
				->description('3% increase')
				->descriptionIcon('heroicon-s-trending-up')
				->color('success'),
		];
	}
}
