<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
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

class CommentResource extends Resource
{
	protected static ?string $model = Comment::class;

	protected static ?string $navigationGroup = 'Post Managment';

	protected static ?string $navigationIcon = 'heroicon-o-chat-alt';
	protected static ?int $navigationSort = 4;


	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Card::make()
					->schema([
						TextInput::make('content')->minLength(2)->required(),
						Select::make('post_id')
							->relationship('post', 'title')->required()->searchable(),
						Select::make('user_id')
							->relationship('user', 'name')->required()->searchable(),
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
				TextColumn::make('content')->sortable(),
				TextColumn::make('post.title')->sortable()->searchable(),
				TextColumn::make('user.name')->sortable()->searchable(),
			])
			->filters([
				SelectFilter::make('post_id')->searchable()->relationship('post', 'title'),
				SelectFilter::make('user_id')->searchable()->relationship('user', 'name'),
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
			'index' => Pages\ListComments::route('/'),
			'create' => Pages\CreateComment::route('/create'),
			'edit' => Pages\EditComment::route('/{record}/edit'),
		];
	}
}