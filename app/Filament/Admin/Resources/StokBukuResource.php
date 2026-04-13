<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StokBukuResource\Pages;
use App\Filament\Admin\Resources\StokBukuResource\RelationManagers;
use App\Models\BookStock;
use App\Models\StokBuku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class StokBukuResource extends Resource
{
    protected static ?string $model = BookStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Stok Buku';

    public static function getModelLabel(): string
    {
        return 'Stok Buku';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Stok Buku';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Buku')
                    ->schema([
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori Buku')
                            ->options([
                                'Fabel' => 'Fabel',
                                'Pendidikan' => 'Pendidikan',
                                'Laporan Karya Ilmiah' => 'Laporan Karya Ilmiah',
                            ])
                            ->required()
                            ->placeholder('Pilih kategori...'),

                        Forms\Components\TextInput::make('judul_buku')
                            ->label('Judul Buku')
                            ->required()
                            ->placeholder('Masukkan judul buku...'),

                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Cover/Sampul Buku')
                            ->image()
                            ->directory('book_covers')
                            ->visibility('public')
                            ->placeholder('Unggah cover buku...')
                            ->disk('public'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detail Stok')
                    ->schema([
                        Forms\Components\TextInput::make('stok_awal')
                            ->label('Stok Awal')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        Forms\Components\TextInput::make('stok_masuk')
                            ->label('Stok Masuk')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\TextInput::make('stok_keluar')
                            ->label('Stok Keluar (Dipinjam)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\TextInput::make('stok_rusak')
                            ->label('Stok Rusak')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\TextInput::make('stok_hilang')
                            ->label('Stok Hilang')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\TextInput::make('stok_saat_ini')
                            ->label('Stok Saat Ini')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Otomatis dihitung'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Catatan')
                    ->schema([
                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan/Catatan')
                            ->rows(4)
                            ->placeholder('Masukkan catatan tentang stok...'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Tabel Stok Buku')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Fabel' => 'info',
                        'Pendidikan' => 'success',
                        'Laporan Karya Ilmiah' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('judul_buku')
                    ->label('Judul Buku')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('foto')
                    ->disk('public')
                    ->height(50)
                    ->hidden()
                    ->getStateUsing(fn  ($record) => $record->cover_image ? asset('storage/' . $record->cover_image) : null),
                Tables\Columns\TextColumn::make('stok_awal')
                    ->label('Stok Awal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok_saat_ini')
                    ->label('Stok Saat Ini')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state <= 0 => 'danger',
                        $state <= 5 => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\TextColumn::make('stok_masuk')
                    ->label('Masuk')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok_keluar')
                    ->label('Keluar')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok_rusak')
                    ->label('Rusak')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stok_hilang')
                    ->label('Hilang')
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel')
                    ->color('success'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->label('Export Terpilih')
                        ->color('success'),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListStokBukus::route('/'),
            'create' => Pages\CreateStokBuku::route('/create'),
            'edit' => Pages\EditStokBuku::route('/{record}/edit'),
        ];
    }
}
