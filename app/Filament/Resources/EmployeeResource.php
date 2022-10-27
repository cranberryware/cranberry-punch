<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Tables;
use App\Models\Employee;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Rules\NumericallyDifferent;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Monarobase\CountryList\CountryListFacade;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static function getNavigationGroup(): ?string
    {
        return strval(__('employee-management::employee-management.section.group-employee-management'));
    }

    public static function getLabel(): string
    {
        return strval(__('employee-management::employee-management.section.employees'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('employee-management::employee-management.section.employee_details'))
                    ->schema([
                        TextInput::make('employee_code')
                            ->label(__('employee-management::employee-management.input.employee_code'))
                            ->placeholder(__('employee-management::employee-management.input.employee_code'))
                            ->required()
                            ->unique(),
                        Select::make('user_id')
                            ->label(__('employee-management::employee-management.input.employee.user'))
                            ->placeholder(__('employee-management::employee-management.input.employee.user'))
                            ->searchable()
                            ->relationship('user', fn () => "email")
                            ->unique(),
                        Select::make('manager_id')
                            ->label(__('employee-management::employee-management.input.manager'))
                            ->placeholder(__('employee-management::employee-management.input.manager'))
                            ->searchable()
                            ->relationship('manager', fn () => "employee_code_with_full_name")
                            ->rules([
                                new NumericallyDifferent(['data.id'], __('employee-management::employee-management.validation.employee_different_from_manager')),
                            ])
                            ->dehydrateStateUsing(fn ($state) => is_numeric($state) ? (int)$state : null),
                        Select::make('department_id')
                            ->label(__('employee-management::employee-management.input.department'))
                            ->placeholder(__('employee-management::employee-management.input.department'))
                            ->searchable()
                            ->relationship('department', fn () => "name"),
                        Select::make('designation_id')
                            ->label(__('employee-management::employee-management.input.designation'))
                            ->placeholder(__('employee-management::employee-management.input.designation'))
                            ->searchable()
                            ->relationship('Designation', fn () => "name"),
                    ])->columns(2),
                Section::make(__('employee-management::employee-management.section.personal'))
                    ->schema([
                        TextInput::make('first_name')
                            ->label(__('employee-management::employee-management.input.first_name'))
                            ->placeholder(__('employee-management::employee-management.input.first_name'))
                            ->required(),
                        TextInput::make('middle_name')
                            ->label(__('employee-management::employee-management.input.middle_name'))
                            ->placeholder(__('employee-management::employee-management.input.middle_name')),
                        TextInput::make('last_name')
                            ->label(__('employee-management::employee-management.input.last_name'))
                            ->placeholder(__('employee-management::employee-management.input.last_name'))
                            ->required(),
                        Radio::make('gender')
                            ->label(__('employee-management::employee-management.input.gender'))
                            ->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'])
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->label(__('employee-management::employee-management.input.date_of_birth'))
                            ->placeholder(__('employee-management::employee-management.input.date_of_birth'))
                            ->required(),
                        DatePicker::make('birthday')
                            ->label(__('employee-management::employee-management.input.birthday'))
                            ->placeholder(__('employee-management::employee-management.input.birthday'))
                            ->required(),
                        Select::make('blood_group')
                            ->label(__('employee-management::employee-management.input.blood_group'))
                            ->placeholder(__('employee-management::employee-management.input.blood_group'))
                            ->options(['A+', 'A−', 'B+', 'B−', 'AB+', 'AB−', 'O+', 'O−'])
                            ->required(),
                        Select::make('nationality')
                            ->label(__('employee-management::employee-management.input.nationality'))
                            ->placeholder(__('employee-management::employee-management.input.nationality'))
                            ->options(CountryListFacade::getList('en'))
                            ->required(),
                        Select::make('country_of_birth')
                            ->label(__('employee-management::employee-management.input.country_of_birth'))
                            ->placeholder(__('employee-management::employee-management.input.country_of_birth'))
                            ->options(CountryListFacade::getList('en'))
                            ->required(),
                    ])
                    ->columns(3)
                    ->collapsible(),
                Section::make(__('employee-management::employee-management.section.family'))
                    ->schema([
                        Select::make('marital_status')
                            ->label(__('employee-management::employee-management.input.marital_status'))
                            ->placeholder(__('employee-management::employee-management.input.marital_status'))
                            ->options(['married' => 'Married', 'unmarried' => 'Unmarried'])
                            ->required()
                            ->reactive(),
                        DatePicker::make('marriage_anniversary')
                            ->label(__('employee-management::employee-management.input.marriage_anniversary'))
                            ->placeholder(__('employee-management::employee-management.input.marriage_anniversary'))
                            ->hidden(fn (Closure $get) => $get('marital_status') !== 'married')
                            ->required(fn (Closure $get) => $get('marital_status') === 'married'),
                        TextInput::make('number_of_children')
                            ->label(__('employee-management::employee-management.input.number_of_children'))
                            ->placeholder(__('employee-management::employee-management.input.number_of_children'))
                            ->numeric()
                            ->hidden(fn (Closure $get) => $get('marital_status') !== 'married')
                            ->required(fn (Closure $get) => $get('marital_status') === 'married'),
                        Fieldset::make('Spouse Details')
                            ->schema([
                                TextInput::make('spouse_first_name')
                                    ->label(__('employee-management::employee-management.input.spouse_first_name'))
                                    ->placeholder(__('employee-management::employee-management.input.spouse_first_name'))
                                    ->required(fn (Closure $get) => $get('marital_status') === 'married'),
                                TextInput::make('spouse_middle_name')
                                    ->label(__('employee-management::employee-management.input.spouse_middle_name'))
                                    ->placeholder(__('employee-management::employee-management.input.spouse_middle_name')),
                                TextInput::make('spouse_last_name')
                                    ->label(__('employee-management::employee-management.input.spouse_last_name'))
                                    ->placeholder(__('employee-management::employee-management.input.spouse_last_name'))
                                    ->required(fn (Closure $get) => $get('marital_status') === 'married'),
                                DatePicker::make('spouse_date_of_birth')
                                    ->label(__('employee-management::employee-management.input.spouse_date_of_birth'))
                                    ->placeholder(__('employee-management::employee-management.input.spouse_date_of_birth'))
                                    ->required(fn (Closure $get) => $get('marital_status') === 'married'),
                                DatePicker::make('spouse_birthday')
                                    ->label(__('employee-management::employee-management.input.spouse_birthday'))
                                    ->placeholder(__('employee-management::employee-management.input.spouse_birthday'))
                                    ->required(fn (Closure $get) => $get('marital_status') === 'married'),
                            ])
                            ->columns(3)
                            ->hidden(fn (Closure $get) => $get('marital_status') !== 'married')
                    ])
                    ->columns(3)
                    ->collapsed(),
                Section::make(__('employee-management::employee-management.section.education'))
                    ->schema([
                        TextInput::make('field_of_study')
                            ->label(__('employee-management::employee-management.input.field_of_study'))
                            ->placeholder(__('employee-management::employee-management.input.field_of_study')),
                        TextInput::make('highest_degree')
                            ->label(__('employee-management::employee-management.input.highest_degree'))
                            ->placeholder(__('employee-management::employee-management.input.highest_degree')),
                    ])
                    ->columns(3)
                    ->collapsed(),
                Section::make(__('employee-management::employee-management.section.identity'))
                    ->schema([
                        TextInput::make('passport_number')
                            ->label(__('employee-management::employee-management.input.passport_number'))
                            ->placeholder(__('employee-management::employee-management.input.passport_number')),
                        TextInput::make('uan')
                            ->label(__('employee-management::employee-management.input.uan'))
                            ->placeholder(__('employee-management::employee-management.input.uan')),
                        TextInput::make('aadhaar_number')
                            ->label(__('employee-management::employee-management.input.aadhaar_number'))
                            ->placeholder(__('employee-management::employee-management.input.aadhaar_number')),
                        TextInput::make('pan_number')
                            ->label(__('employee-management::employee-management.input.pan_number'))
                            ->placeholder(__('employee-management::employee-management.input.pan_number')),
                        TextInput::make('driving_license_number')
                            ->label(__('employee-management::employee-management.input.driving_license_number'))
                            ->placeholder(__('employee-management::employee-management.input.driving_license_number')),
                        TextInput::make('voter_id')
                            ->label(__('employee-management::employee-management.input.voter_id'))
                            ->placeholder(__('employee-management::employee-management.input.voter_id')),
                    ])
                    ->columns(3)
                    ->collapsed(),
                Section::make(__('employee-management::employee-management.section.contact'))
                    ->schema([
                        TextInput::make('work_email')
                            ->label(__('employee-management::employee-management.input.work_email'))
                            ->placeholder(__('employee-management::employee-management.input.work_email'))
                            ->email(),
                        TextInput::make('work_phone_1')
                            ->label(__('employee-management::employee-management.input.work_phone_1'))
                            ->placeholder(__('employee-management::employee-management.input.work_phone_1'))
                            ->tel(),
                        TextInput::make('work_phone_2')
                            ->label(__('employee-management::employee-management.input.work_phone_2'))
                            ->placeholder(__('employee-management::employee-management.input.work_phone_2'))
                            ->tel(),
                        TextInput::make('present_address_line_1')
                            ->label(__('employee-management::employee-management.input.present_address_line_1'))
                            ->placeholder(__('employee-management::employee-management.input.present_address_line_1')),
                        TextInput::make('present_address_line_2')
                            ->label(__('employee-management::employee-management.input.present_address_line_2'))
                            ->placeholder(__('employee-management::employee-management.input.present_address_line_2')),
                        TextInput::make('present_address_city')
                            ->label(__('employee-management::employee-management.input.present_address_city'))
                            ->placeholder(__('employee-management::employee-management.input.present_address_city')),
                        TextInput::make('present_address_state')
                            ->label(__('employee-management::employee-management.input.present_address_state'))
                            ->placeholder(__('employee-management::employee-management.input.present_address_state')),
                        TextInput::make('present_address_post_code')
                            ->label(__('employee-management::employee-management.input.present_address_post_code'))
                            ->placeholder(__('employee-management::employee-management.input.present_address_post_code')),
                        Select::make('present_address_country')
                            ->label(__('employee-management::employee-management.input.present_address_country'))
                            ->placeholder(__('employee-management::employee-management.input.present_address_country'))
                            ->options(CountryListFacade::getList('en')),
                    ])
                    ->columns(3)
                    ->collapsed(),
                Section::make(__('employee-management::employee-management.section.personal_contact'))
                    ->schema([
                        TextInput::make('personal_email')
                            ->label(__('employee-management::employee-management.input.personal_email'))
                            ->placeholder(__('employee-management::employee-management.input.personal_email'))
                            ->email(),
                        TextInput::make('personal_phone')
                            ->label(__('employee-management::employee-management.input.personal_phone'))
                            ->placeholder(__('employee-management::employee-management.input.personal_phone'))
                            ->tel(),
                        TextInput::make('emergency_contact_name')
                            ->label(__('employee-management::employee-management.input.emergency_contact_name'))
                            ->placeholder(__('employee-management::employee-management.input.emergency_contact_name')),
                        TextInput::make('emergency_contact_relation')
                            ->label(__('employee-management::employee-management.input.emergency_contact_relation'))
                            ->placeholder(__('employee-management::employee-management.input.emergency_contact_relation')),
                        TextInput::make('emergency_contact_phone')
                            ->label(__('employee-management::employee-management.input.emergency_contact_phone'))
                            ->placeholder(__('employee-management::employee-management.input.emergency_contact_phone'))
                            ->tel(),
                        TextInput::make('permanent_address_line_1')
                            ->label(__('employee-management::employee-management.input.permanent_address_line_1'))
                            ->placeholder(__('employee-management::employee-management.input.permanent_address_line_1')),
                        TextInput::make('permanent_address_line_2')
                            ->label(__('employee-management::employee-management.input.permanent_address_line_2'))
                            ->placeholder(__('employee-management::employee-management.input.permanent_address_line_2')),
                        TextInput::make('permanent_address_city')
                            ->label(__('employee-management::employee-management.input.permanent_address_city'))
                            ->placeholder(__('employee-management::employee-management.input.permanent_address_city')),
                        TextInput::make('permanent_address_state')
                            ->label(__('employee-management::employee-management.input.permanent_address_state'))
                            ->placeholder(__('employee-management::employee-management.input.permanent_address_state')),
                        TextInput::make('permanent_address_post_code')
                            ->label(__('employee-management::employee-management.input.permanent_address_post_code'))
                            ->placeholder(__('employee-management::employee-management.input.permanent_address_post_code')),
                        Select::make('permanent_address_country')
                            ->label(__('employee-management::employee-management.input.permanent_address_country'))
                            ->placeholder(__('employee-management::employee-management.input.permanent_address_country'))
                            ->options(CountryListFacade::getList('en')),
                    ])
                    ->columns(3)
                    ->collapsed(),
                Section::make(__('employee-management::employee-management.section.financial'))
                    ->schema([
                        TextInput::make('bank_account_number')
                            ->label(__('employee-management::employee-management.input.bank_account_number'))
                            ->placeholder(__('employee-management::employee-management.input.bank_account_number')),
                        TextInput::make('bank_name')
                            ->label(__('employee-management::employee-management.input.bank_name'))
                            ->placeholder(__('employee-management::employee-management.input.bank_name')),
                        TextInput::make('bank_ifsc_code')
                            ->label(__('employee-management::employee-management.input.bank_ifsc_code'))
                            ->placeholder(__('employee-management::employee-management.input.bank_ifsc_code')),
                        TextInput::make('bank_micr_code')
                            ->label(__('employee-management::employee-management.input.bank_micr_code'))
                            ->placeholder(__('employee-management::employee-management.input.bank_micr_code')),
                        TextInput::make('bank_swift_code')
                            ->label(__('employee-management::employee-management.input.bank_swift_code'))
                            ->placeholder(__('employee-management::employee-management.input.bank_swift_code')),
                        TextInput::make('bank_iban_code')
                            ->label(__('employee-management::employee-management.input.bank_iban_code'))
                            ->placeholder(__('employee-management::employee-management.input.bank_iban_code')),
                        TextInput::make('bank_address_line_1')
                            ->label(__('employee-management::employee-management.input.bank_address_line_1'))
                            ->placeholder(__('employee-management::employee-management.input.bank_address_line_1')),
                        TextInput::make('bank_address_line_2')
                            ->label(__('employee-management::employee-management.input.bank_address_line_2'))
                            ->placeholder(__('employee-management::employee-management.input.bank_address_line_2')),
                        TextInput::make('bank_address_city')
                            ->label(__('employee-management::employee-management.input.bank_address_city'))
                            ->placeholder(__('employee-management::employee-management.input.bank_address_city')),
                        TextInput::make('bank_address_state')
                            ->label(__('employee-management::employee-management.input.bank_address_state'))
                            ->placeholder(__('employee-management::employee-management.input.bank_address_state')),
                        TextInput::make('bank_address_post_code')
                            ->label(__('employee-management::employee-management.input.bank_address_post_code'))
                            ->placeholder(__('employee-management::employee-management.input.bank_address_post_code')),
                        Select::make('bank_address_country')
                            ->label(__('employee-management::employee-management.input.bank_address_country'))
                            ->placeholder(__('employee-management::employee-management.input.bank_address_country'))
                            ->options(CountryListFacade::getList('en')),
                        TextInput::make('bank_phone')
                            ->label(__('employee-management::employee-management.input.bank_phone'))
                            ->placeholder(__('employee-management::employee-management.input.bank_phone'))
                            ->tel(),
                        TextInput::make('bank_email')
                            ->label(__('employee-management::employee-management.input.bank_email'))
                            ->placeholder(__('employee-management::employee-management.input.bank_email'))
                            ->email(),
                    ])
                    ->columns(3)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_code')
                    ->label(__('employee-management::employee-management.table.employee_code'))
                    ->sortable(),
                TextColumn::make('full_name')
                    ->label(__('employee-management::employee-management.table.full_name'))
                    ->sortable(),
                TextColumn::make('department.name')
                    ->label(__('employee-management::employee-management.table.department.name'))
                    ->sortable(),
                TextColumn::make('designation.name')
                    ->label(__('employee-management::employee-management.table.designation.name'))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                ExportBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
