<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\{TextInput, DatePicker, Section, FileUpload, Select};
use App\Filament\Resources\ResidentResource\Pages;
use App\Models\Tower;
use Filament\Forms\Get;
use App\Models\Resident;
use App\Models\Condominium;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class ResidentResource extends Resource
{
    protected static ?string $model = Resident::class;

    protected static ?string $label = 'Morador';
    protected static ?string $pluralLabel = 'Morador';
    protected static ?string $navigationLabel = 'Morador';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Morador')
                    ->schema([
                        FileUpload::make('resident.url_image')
                            ->label('Foto')
                            ->image()
                            ->directory('residents'),

                        TextInput::make('resident.name')
                            ->label('Nome')
                            ->required(),

                        TextInput::make('resident.cpf')
                            ->label('CPF'),

                        TextInput::make('resident.rg')
                            ->label('RG'),

                        DatePicker::make('resident.birth_date')
                            ->label('Data de nascimento')
                            ,

                        TextInput::make('resident.phone')
                            ->label('Telefone'),

                        TextInput::make('resident.email')
                            ->label('E-mail')
                            ->email(),

                        Select::make('resident.condominium_id')
                            ->label('Condomínio')
                            ->options(
                                Condominium::pluck('name', 'id')
                            )
                            ->searchable()
                            ->reactive(),

                        Select::make('resident.tower_id')
                            ->label('Torre')
                            ->options(function (Get $get) {
                                $condominiumId = $get('resident.condominium_id');
                                if (!$condominiumId) {
                                    return [];
                                }
                                return Tower::where('condominium_id', $condominiumId)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->disabled(fn(Get $get) => !$get('resident.condominium_id')),

                        Select::make('resident.status_id')
                            ->label('Status'),
                    ])
                    ->columns(2),

                Section::make('Veículo')
                    ->schema([
                        TextInput::make('drive.description')
                            ->label('Descrição'),

                        TextInput::make('drive.plate_number')
                            ->label('Placa'),

                        TextInput::make('drive.model')
                            ->label('Modelo'),

                        TextInput::make('drive.color')
                            ->label('Cor'),
                    ])
                    ->columns(2),

                Section::make('Empregador')
                    ->schema([
                        TextInput::make('employer.name')
                            ->label('Nome'),

                        TextInput::make('employer.cpf')
                            ->label('CPF'),

                        TextInput::make('employer.rg')
                            ->label('RG'),
                    ])
                    ->columns(2),

                Section::make('Animal')
                    ->schema([
                        TextInput::make('animals.breed')
                            ->label('Raça'),

                        TextInput::make('animals.size')
                            ->label('Porte'),
                    ])
                    ->columns(2),

                Section::make('Apartamento')
                    ->schema([
                        TextInput::make('apartment.name')
                            ->label('Apartamento'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),

                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->searchable(),

                Tables\Columns\TextColumn::make('rg')
                    ->label('RG')
                    ->searchable(),

                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Data Nasci')
                    ->date('d/m/Y'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Cadastro')
                    ->date('d/m/Y H:i'),
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
            'index' => Pages\ListResidents::route('/'),
            'create' => Pages\CreateResident::route('/create'),
            'edit' => Pages\EditResident::route('/{record}/edit'),
        ];
    }
}
