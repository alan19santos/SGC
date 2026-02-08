<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CondominiumResource\Pages;
use App\Filament\Resources\CondominiumResource\RelationManagers;
use App\Models\Condominium;
use Illuminate\Database\Eloquent\Model;
use App\Services\CondominiumService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CondominiumResource extends Resource
{
    protected static ?string $model = Condominium::class;
    protected static ?string $label = 'Condomínio';
    protected static ?string $pluralLabel = 'Condomínios';

    protected static ?string $navigationLabel = 'Condomínios';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('address'),
            Forms\Components\TextInput::make('qtd_ap'),
            Forms\Components\TextInput::make('qtd_tower'),
            Forms\Components\TextInput::make('city'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nome')
                ->searchable(),

                Tables\Columns\TextColumn::make('address')
                ->label('Endereço')
                ->searchable(),

                Tables\Columns\TextColumn::make('city')
                ->label('Cidade')
                ->searchable(),

                Tables\Columns\TextColumn::make('qtd_tower')
                ->label('Torres')
                ->searchable(),

                Tables\Columns\TextColumn::make('qtd_ap')
                ->label('Ap')
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListCondominia::route('/'),
            'create' => Pages\CreateCondominium::route('/create'),
            'edit' => Pages\EditCondominium::route('/{record}/edit'),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        return app(CondominiumService::class)->storeForAdmin($data);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(CondominiumService::class)
            ->updateForAdmin($data, $record->id);
    }
}
