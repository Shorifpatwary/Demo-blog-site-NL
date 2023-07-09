<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Closure;

use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use stdClass;

class PostResource extends Resource
{
	protected static ?string $model = Post::class;


	protected static ?string $navigationGroup = 'Post Managment';

	protected static ?string $navigationIcon = 'heroicon-o-book-open';
	protected static ?int $navigationSort = 1;

	public static function form(Form $form): Form
	{
		return $form
			->schema([
				Card::make()
					->schema([
						TextInput::make('title')->minLength(2)->maxLength(100)->required()->unique(ignoreRecord: true)->reactive()
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
						MarkdownEditor::make('excerpt')
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
							])->minLength(15)->maxLength(300),
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
							->directory("/postImage")
							->required(),
						// meta_title
						TextInput::make('meta_title')
							->minLength(2)
							->maxLength(300),
						TextInput::make('meta_description')
							->minLength(2)
							->maxLength(300),

						Radio::make('status')
							->options([
								'draft' => 'Draft',
								// 'scheduled' => 'Scheduled',
								'published' => 'Published'
							])
							->descriptions([
								'draft' => 'Is not visible.',
								// 'scheduled' => 'Will be visible.',
								'published' => 'Is visible.'
							])->default('published'),
						Toggle::make('comments_enabled')->inline()->default(true),
						// hidden field 
						Hidden::make('user_id')->default(Auth::id()),
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
				TextColumn::make('title')->sortable()->searchable(),
				// TextColumn::make('status')->sortable()->searchable(),
				BadgeColumn::make('status')
					->enum([
						'draft' => 'Draft',
						// 'reviewing' => 'Reviewing',
						'published' => 'Published',
					])
					->colors([
						'primary',
						'warning' => 'draft',
						'success' => 'published',
					])
					->icons([
						'heroicon-o-document' => 'draft',
						'heroicon-o-truck' => 'published',
					])->searchable(),
				TextColumn::make('published_at')->sortable(),
				TextColumn::make('views')->sortable(),
				// TextColumn::make('comments_enabled')->sortable(),
				IconColumn::make('comments_enabled')->boolean(),
				ImageColumn::make('image')->width(200)->defaultImageUrl('https://via.placeholder.com/640x480.png/00ffff?text=animals+autem'),
			])
			->filters([
				SelectFilter::make('status')
					->options([
						'draft' => 'Draft',
						'published' => 'Published',
					]),
				SelectFilter::make('user_id')->searchable()->relationship('user', 'name'),
				SelectFilter::make('category_id')->searchable()->relationship('category', 'name'),
				SelectFilter::make('tag_id')->searchable()->relationship('tag', 'name'),
				Filter::make('created_at')
					->form([
						Forms\Components\DatePicker::make('created_from'),
						Forms\Components\DatePicker::make('created_until')->default(now()),
					]),
				Filter::make('comments_enabled')->toggle(),
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
			'index' => Pages\ListPosts::route('/'),
			'create' => Pages\CreatePost::route('/create'),
			'edit' => Pages\EditPost::route('/{record}/edit'),
		];
	}
}