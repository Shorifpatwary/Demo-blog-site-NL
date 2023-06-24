<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use stdClass;

class TagResource extends Resource
{
	protected static ?string $model = Tag::class;

	protected static ?string $navigationGroup = 'Post Managment';

	protected static ?string $navigationIcon = 'heroicon-o-tag';
	protected static ?int $navigationSort = 3;

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Card::make()
					->schema([
						TextInput::make('name')->minLength(2)->maxLength(30)->required()->unique(ignoreRecord: true)->reactive()
							->afterStateUpdated(function (Closure $set, $state) {
								$set('slug', Str::slug($state));
							}),
						// TextInput::make('description')->minLength(15),
						MarkdownEditor::make('description')
							->toolbarButtons([
								'attachFiles',
								'bold',
								'bulletList',
								'codeBlock',
								'edit',
								'italic',
								'link',
								'orderedList',
								'preview',
								'strike',
							])->minLength(15),
						TextInput::make('slug')
							->minLength(2)
							->maxLength(40)
							->required()
							->unique(ignoreRecord: true)
							// ->readOnly()
							->reactive(),
						// image  
						FileUpload::make('image')
							->maxSize(200) // Limit the file size to 200 KB
							->acceptedFileTypes(['image/*']) // Only accept image files
							->unique()
							->nullable()
							->preserveFilenames()
							->imageCropAspectRatio('16:9')
							->directory("/tagImage"),
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
				TextColumn::make('name')->sortable()->searchable(),
				// TextColumn::make('description')->sortable()->searchable(),
				TextColumn::make('slug')->sortable()->searchable(),
				ImageColumn::make('image')->width(200)->defaultImageUrl('https://via.placeholder.com/640x480.png/00ffff?text=animals+autem'),
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
			'index' => Pages\ListTags::route('/'),
			'create' => Pages\CreateTag::route('/create'),
			'edit' => Pages\EditTag::route('/{record}/edit'),
		];
	}
}