<?php

namespace App\Filament\Resources;

use App\Models\Book;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;


class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Koleksi Buku';
    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'books';

    public static function getLabel(): string
    {
        return 'Buku';
    }

    public static function getPluralLabel(): string
    {
        return 'Koleksi Buku';
    }

    // ✅ HARUS DI DALAM CLASS
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Informasi Buku')
                ->description('Isi data lengkap buku')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Buku')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('author')
                        ->label('Pengarang')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('isbn')
                        ->label('ISBN')
                        ->unique(ignoreRecord: true)
                        ->maxLength(20),

                    Forms\Components\TextInput::make('publisher')
                        ->label('Penerbit')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('publish_year')
                        ->label('Tahun Terbit')
                        ->numeric()
                        ->minValue(1900)
                        ->maxValue(now()->year),
                ])
                ->columns(2),

            Forms\Components\Section::make('Kategori & Stok')
                ->schema([
                    Forms\Components\Select::make('category')
                        ->options([
                            'Umum' => 'Umum',
                            'Fiksi' => 'Fiksi',
                            'Non-Fiksi' => 'Non-Fiksi',
                            'Referensi' => 'Referensi',
                            'Pelajaran' => 'Pelajaran',
                            'Komik' => 'Komik',
                        ])
                        ->default('Umum'),

                    Forms\Components\TextInput::make('initial_quantity')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('current_quantity')
                        ->numeric()
                        ->required(),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author')
                    ->label('Pengarang')
                    ->searchable(),

                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('current_quantity')
                    ->label('Stok'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}