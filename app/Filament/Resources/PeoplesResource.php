<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\{TextInput, DatePicker, Section, FileUpload};
use App\Filament\Resources\PeoplesResource\Pages;
use App\Filament\Resources\PeoplesResource\RelationManagers;
use App\Models\Peoples;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use App\Services\PeoplesServices;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeoplesResource extends Resource
{
    protected static ?string $model = Peoples::class;

    protected static ?string $label = 'Pessoa';
    protected static ?string $pluralLabel = 'Pessoa';

    protected static ?string $navigationLabel = 'Pessoa';
    protected static ?string $navigationIcon = 'heroicon-o-user';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dados pessoais')
                    ->schema([
                        TextInput::make('people.name')->label('Nome')->required()->columnSpan(1),
                        DatePicker::make('people.date_birth')->label('Data Nascimento')->required()->columnSpan(1),
                        TextInput::make('people.cpf')->label('CPF')->required()->columnSpan(1),
                        TextInput::make('people.rg')->label('RG')->columnSpan(1),
                        TextInput::make('people.email')->label('Email')->email()->required()->columnSpan(1),
                        FileUpload::make('people.photo')->label('Foto')->image()->helperText('Clique em "browse" ou arraste a imagem aqui')->required()->columnSpan(1),
                        TextInput::make('people.phone')->label('Tel')->columnSpan(1),
                        TextInput::make('people.address')->label('Endereço')->columnSpan(1),
                        TextInput::make('people.emergency_contact')->label('Contato Emergência')->columnSpan(1),
                        TextInput::make('people.observation')->label('Observação')->columnSpan(4),
                    ]),

                Section::make('Veículo')
                    ->schema([
                        TextInput::make('drive.description'),
                        TextInput::make('drive.plate_number'),
                        TextInput::make('drive.model'),
                        TextInput::make('drive.color'),
                    ]),

                Section::make('Funcionário')
                    ->schema([
                        TextInput::make('employee.name'),
                        TextInput::make('employee.cpf'),
                        TextInput::make('employee.rg'),
                    ]),

                Section::make('Dados bancários')
                    ->schema([
                        TextInput::make('bank.branch_number'),
                        TextInput::make('bank.branch_digit_number'),
                        TextInput::make('bank.bank_name'),
                        TextInput::make('bank.bank_account_number'),
                        TextInput::make('bank.bank_account_digit'),
                        TextInput::make('bank.pix'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),

                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->searchable(),

                Tables\Columns\TextColumn::make('rg')
                    ->label('RG')
                    ->searchable(),

                Tables\Columns\TextColumn::make('date_birth')
                    ->label('Data Nasci')
                    ->date('d/m/Y')
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
            'index' => Pages\ListPeoples::route('/'),
            'create' => Pages\CreatePeoples::route('/create'),
            'edit' => Pages\EditPeoples::route('/{record}/edit'),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        return app(PeoplesServices::class)->storeFormDataForAdmin($data);
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return app(PeoplesServices::class)
            ->updateForAdmin($data, $record->id);
    }
}
