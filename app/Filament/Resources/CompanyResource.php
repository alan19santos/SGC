<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationLabel = 'Empresas';
     protected static ?string $label = 'Empresa';
    protected static ?string $pluralLabel = 'Empresas';
    protected static ?string $navigationGroup = 'Cadastros';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_company')
                    ->label('Nome da Empresa')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('cnpj')
                    ->label('CNPJ')
                    ->mask('99.999.999/9999-99')
                    ->required(),

                Forms\Components\TextInput::make('responsible_name')
                    ->label('Responsável')
                    ->maxLength(255)
                    ->required(),

                Forms\Components\TextInput::make('phone')
                    ->label('Telefone')
                    ->mask('(99) 99999-9999'),

                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required(),

                Forms\Components\Select::make('type_service_id')
                    ->label('Tipo de Serviço')
                    ->options(
                        \App\Models\TypeService::pluck('name', 'id')
                    )
                    ->searchable()
                    ->required(),

                Forms\Components\Textarea::make('observation')
                    ->label('Observações')
                    ->rows(3),

                Forms\Components\Toggle::make('isActive')
                    ->label('Ativa')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_company')
                    ->label('Empresa')
                    ->searchable(),

                Tables\Columns\TextColumn::make('cnpj'),

                Tables\Columns\TextColumn::make('responsible_name')
                    ->label('Responsável'),

                Tables\Columns\IconColumn::make('isActive')
                    ->label('Ativa')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastro')
                    ->date('d/m/Y'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('isActive')
                    ->label('Ativa'),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
