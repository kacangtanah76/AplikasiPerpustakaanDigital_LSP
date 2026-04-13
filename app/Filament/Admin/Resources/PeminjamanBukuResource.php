<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PeminjamanBukuResource\Pages;
use App\Filament\Admin\Resources\PeminjamanBukuResource\RelationManagers;
use App\Models\PeminjamanBuku;
use App\Models\BookStock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class PeminjamanBukuResource extends Resource
{
    protected static ?string $model = PeminjamanBuku::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-top-right-on-square';

    protected static ?string $navigationLabel = 'Peminjaman Buku';

    public static function getModelLabel(): string
    {
        return 'Peminjaman Buku';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Peminjaman Buku';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Peminjam')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Nama Peminjam')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),

                Forms\Components\Section::make('Data Buku')
                    ->schema([
                        Forms\Components\Select::make('book_stock_id')
                            ->label('Pilih Buku')
                            ->options(function () {
                                return BookStock::all()->mapWithKeys(fn ($stock) => [
                                    $stock->id => "{$stock->judul_buku} ({$stock->kategori})"
                                ]);
                            })
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $stock = BookStock::find($state);
                                    if ($stock) {
                                        $set('kategori', $stock->kategori);
                                        $set('judul_buku', $stock->judul_buku);
                                    }
                                }
                            })
                            ->live(),

                        Forms\Components\TextInput::make('kategori')
                            ->label('Kategori Buku')
                            ->disabled()
                            ->dehydrated(true),

                        Forms\Components\TextInput::make('judul_buku')
                            ->label('Judul Buku')
                            ->required()
                            ->dehydrated(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Tanggal Peminjaman')
                    ->schema([
                        Forms\Components\DateTimePicker::make('tanggal_peminjaman')
                            ->label('Tanggal Peminjaman')
                            ->required()
                            ->default(now())
                            ->disabledOn('edit'),

                        Forms\Components\DateTimePicker::make('tanggal_kembali_rencana')
                            ->label('Tanggal Kembali Rencana')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Riwayat Pengembalian')
                    ->schema([
                        Forms\Components\DateTimePicker::make('tanggal_kembali_aktual')
                            ->label('Tanggal Kembali Aktual')
                            ->visible(fn (Forms\Get $get) => $get('status') === 'dikembalikan'),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'dipinjam' => 'Dipinjam',
                                'dikembalikan' => 'Dikembalikan',
                                'hilang' => 'Hilang',
                            ])
                            ->required()
                            ->default('dipinjam')
                            ->live(),

                        Forms\Components\TextInput::make('denda')
                            ->label('Denda (Rp)')
                            ->numeric()
                            ->prefix('Rp ')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Catatan')
                    ->schema([
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan/Keterangan')
                            ->rows(4)
                            ->placeholder('Masukkan catatan peminjaman...'),
                    ]),
                Forms\Components\FileUpload::make('foto')
                                 ->image()
                                     ->directory('temp')
                                 ->dehydrated(false)
                ]);   
             }


    public static function table(Table $table): Table
    {
        return $table
            ->heading('Tabel Peminjaman Buku')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Peminjam')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
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
                        ->label('Foto')
                        ->disk('public')
                        ->height(50)
                        ->hidden(),

                Tables\Columns\TextColumn::make('tanggal_peminjaman')
                    ->label('Tgl Pinjam')
                    ->dateTime('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_kembali_rencana')
                    ->label('Tgl Kembali Plan')
                    ->dateTime('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success',
                        'hilang' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('hari_terlambat')
                    ->label('Hari Terlambat')
                    ->getStateUsing(function (PeminjamanBuku $record) {
                        if ($record->status === 'dipinjam' && $record->tanggal_kembali_rencana && $record->isTerlambat()) {
                            return now()->diffInDays($record->tanggal_kembali_rencana) . ' hari';
                        } elseif ($record->status === 'dikembalikan' && $record->tanggal_kembali_aktual && $record->tanggal_kembali_rencana && $record->tanggal_kembali_aktual > $record->tanggal_kembali_rencana) {
                            return $record->tanggal_kembali_aktual->diffInDays($record->tanggal_kembali_rencana) . ' hari';
                        }
                        return '—';
                    })
                    ->sortable(false),

                Tables\Columns\TextColumn::make('denda')
                    ->label('Denda (Rp)')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'hilang' => 'Hilang',
                    ]),

                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'Fabel' => 'Fabel',
                        'Pendidikan' => 'Pendidikan',
                        'Laporan Karya Ilmiah' => 'Laporan Karya Ilmiah',
                    ]),
            ])
                    
        
            ->headerActions([
                ExportAction::make()
                    ->label('Export Excel')
                    ->color('success'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Tandai Dikembalikan')
                    ->visible(fn (PeminjamanBuku $record) => $record->status === 'dipinjam')
                    ->form([
                        Forms\Components\DateTimePicker::make('tanggal_kembali_aktual')
                            ->label('Tanggal Kembali Aktual')
                            ->required()
                            ->default(now()),
                    ])
                    ->action(function (PeminjamanBuku $record, array $data) {
                        $record->setAttribute('tanggal_kembali_aktual', $data['tanggal_kembali_aktual']);
                        $record->markAsReturned();
                    })
                    ->modalHeading(function (PeminjamanBuku $record) {
                        $denda = $record->calculateDenda();
                        if ($denda > 0) {
                            return '⚠️ Konfirmasi Pengembalian - Ada Denda';
                        }
                        return 'Konfirmasi Pengembalian Buku';
                    })
                    ->modalDescription(function (PeminjamanBuku $record) {
                        $hariTerlambat = 0;
                        if ($record->tanggal_kembali_rencana && $record->isTerlambat()) {
                            $hariTerlambat = now()->diffInDays($record->tanggal_kembali_rencana);
                        }
                        $denda = $record->calculateDenda();
                        
                        $text = "Judul Buku: {$record->judul_buku}\n";
                        $text .= "Tanggal Kembali Rencana: " . $record->tanggal_kembali_rencana->format('d M Y') . "\n";
                        
                        if ($hariTerlambat > 0) {
                            $text .= "Hari Terlambat: {$hariTerlambat} hari\n";
                            $text .= "Denda: Rp " . number_format($denda, 0, ',', '.') . " (Rp 5000/hari)\n";
                        } else {
                            $text .= "Status: Tepat waktu, tidak ada denda ✓";
                        }
                        
                        return $text;
                    })
                    ->after(function (PeminjamanBuku $record) {
                        $denda = $record->denda;
                        if ($denda > 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Buku Dikembalikan dengan Denda')
                                ->body("Status peminjaman berhasil diubah. Denda: Rp " . number_format($denda, 0, ',', '.'))
                                ->warning()
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Buku Dikembalikan')
                                ->body('Status peminjaman berhasil diubah menjadi dikembalikan. Tidak ada denda.')
                                ->success()
                                ->send();
                        }
                    })
                    ->color('success'),

                Tables\Actions\Action::make('Tandai Hilang')
                    ->visible(fn (PeminjamanBuku $record) => $record->status === 'dipinjam')
                    ->form([
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan Kehilangan')
                            ->required(),
                    ])
                    ->action(fn (PeminjamanBuku $record, array $data) => $record->markAsLost($data['catatan']))
                    ->after(function () {
                        \Filament\Notifications\Notification::make()
                            ->title('Buku Ditandai Hilang')
                            ->body('Status peminjaman berhasil diubah menjadi hilang.')
                            ->danger()
                            ->send();
                    })
                    ->color('danger'),
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
            'index' => Pages\ListPeminjamanBukus::route('/'),
            'create' => Pages\CreatePeminjamanBuku::route('/create'),
            'edit' => Pages\EditPeminjamanBuku::route('/{record}/edit'),
        ];
    }
}
