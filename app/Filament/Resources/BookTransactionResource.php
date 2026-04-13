<?php

namespace App\Filament\Resources;

use App\Models\Book;
use App\Models\BookTransaction;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class BookTransactionResource extends Resource
{
    protected static ?string $model = BookTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-left';
    protected static ?string $navigationLabel = 'Transaksi Buku';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'transactions';

    public static function getLabel(): string
    {
        return 'Transaksi';
    }

    public static function getPluralLabel(): string
    {
        return 'Transaksi Buku';
    }

    // ✅ FIX DI SINI (v4)
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Detail Transaksi')
                ->schema([
                    Forms\Components\Select::make('book_id')
                        ->label('Buku')
                        ->options(Book::pluck('title', 'id'))
                        ->required()
                        ->searchable(),

                    Forms\Components\Select::make('user_id')
                        ->label('User/Admin')
                        ->options(User::pluck('name', 'id'))
                        ->default(Auth::id())
                        ->required()
                        ->searchable(),

                    Forms\Components\Select::make('transaction_type')
                        ->label('Tipe Transaksi')
                        ->options([
                            'masuk' => 'Masuk (Penambahan Stok)',
                            'keluar' => 'Keluar (Pengurangan Stok)',
                            'pengembalian' => 'Pengembalian',
                            'rusak' => 'Rusak/Hilang',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('quantity')
                        ->label('Jumlah')
                        ->numeric()
                        ->required()
                        ->minValue(1),
                ])
                ->columns(2),

            Forms\Components\Section::make('Keterangan')
                ->schema([
                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan')
                        ->rows(3),

                    Forms\Components\DateTimePicker::make('transaction_date')
                        ->label('Tanggal Transaksi')
                        ->default(now())
                        ->required(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ExportAction::make('export')])
                 ->label('Export Laporan Buku')
                 ->filename ('Laporan-Buku')
            ->columns([
                Tables\Columns\TextColumn::make('book.title')
                    ->label('Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User/Admin')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('transaction_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'masuk' => 'success',
                        'keluar' => 'danger',
                        'pengembalian' => 'warning',
                        'rusak' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(30),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('transaction_type')
                    ->options([
                        'masuk' => 'Masuk',
                        'keluar' => 'Keluar',
                        'pengembalian' => 'Pengembalian',
                        'rusak' => 'Rusak',
                    ]),

                Tables\Filters\SelectFilter::make('book_id')
                    ->label('Buku')
                    ->options(Book::pluck('title', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // ✅ HANDLE UPDATE STOK (cukup di sini saja)
    public static function afterCreate(BookTransaction $record): void
    {
        $book = $record->book;

        if (!$book) return;

        match ($record->transaction_type) {
            'masuk', 'pengembalian' => $book->increment('current_quantity', $record->quantity),
            'keluar', 'rusak' => $book->decrement('current_quantity', $record->quantity),
        };
    }
}