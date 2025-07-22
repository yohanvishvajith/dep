<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Closure;
use Filament\Forms\Components\TextInput;
use App\Models\Vehicle;
use Illuminate\Support\Collection;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Select::make('vehicle_id')
                ->label('Select Vehicle')
                ->options(function (): array {
                    return Vehicle::where('is_available', true)
                        ->orderBy('brand')
                        ->orderBy('model')
                        ->get()
                        ->mapWithKeys(function (Vehicle $vehicle) {
                            return [
                                $vehicle->vehicle_id => "{$vehicle->brand} {$vehicle->model} (Reg: {$vehicle->registration_number})"
                            ];
                        })
                        ->toArray();
                })
                ->searchable()
                ->required()
                ->native(false)
                ->live()
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    if ($vehicle = Vehicle::find($state)) {
                        $set('daily_rate', $vehicle->daily_rate);
                    }
                    // Clear dates when vehicle changes
                    $set('start_date', null);
                    $set('end_date', null);
                    $set('total_cost', 0);
                }),

                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Start Date')
                    ->default(now()->toDateString())
                    ->minDate(now()->toDateString())
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('end_date', null);
                        $set('total_cost', 0);
                    })
                    ->rules([
                        function (Get $get) {
                            return function (string $attribute, $value, Closure $fail) use ($get) {
                                $vehicleId = $get('vehicle_id');
                                $endDate = $get('end_date');
                                
                                if ($vehicleId && $value) {
                                    // Check for overlapping reservations
                                    $query = Reservation::where('vehicle_id', $vehicleId)
                                        ->where('status', '!=', 'cancelled')
                                        ->where(function ($q) use ($value, $endDate) {
                                            if ($endDate) {
                                                // Check if new reservation overlaps with existing ones
                                                $q->where(function ($subQ) use ($value, $endDate) {
                                                    $subQ->whereBetween('start_date', [$value, $endDate])
                                                        ->orWhereBetween('end_date', [$value, $endDate])
                                                        ->orWhere(function ($innerQ) use ($value, $endDate) {
                                                            $innerQ->where('start_date', '<=', $value)
                                                                ->where('end_date', '>=', $endDate);
                                                        });
                                                });
                                            }
                                        });
                                    
                                    // Exclude current record when editing
                                    if ($recordId = request()->route('record')) {
                                        $query->where('reservation_id', '!=', $recordId);
                                    }
                                    
                                    if ($query->exists()) {
                                        $fail('This vehicle is already reserved for the selected date range.');
                                    }
                                }
                            };
                        }
                    ]),

                 Forms\Components\DateTimePicker::make('end_date')
                    ->label('End Date')
                    ->required()
                    ->minDate(function (Get $get) {
                        return $get('start_date') ?: now()->toDateString();
                    })
                    ->rules([
                        function (Get $get) {
                            return function (string $attribute, $value, Closure $fail) use ($get) {
                                $startDate = $get('start_date');
                                $vehicleId = $get('vehicle_id');
                                
                                // Check if end date is after start date
                                if ($startDate && $value < $startDate) {
                                    $fail('The end date must be after the start date.');
                                }
                                
                                // Check for overlapping reservations
                                if ($vehicleId && $startDate && $value) {
                                    $query = Reservation::where('vehicle_id', $vehicleId)
                                        ->where('status', '!=', 'cancelled')
                                        ->where(function ($q) use ($startDate, $value) {
                                            // Check if new reservation overlaps with existing ones
                                            $q->where(function ($subQ) use ($startDate, $value) {
                                                $subQ->whereBetween('start_date', [$startDate, $value])
                                                    ->orWhereBetween('end_date', [$startDate, $value])
                                                    ->orWhere(function ($innerQ) use ($startDate, $value) {
                                                        $innerQ->where('start_date', '<=', $startDate)
                                                            ->where('end_date', '>=', $value);
                                                    });
                                            });
                                        });
                                    
                                    // Exclude current record when editing
                                    if ($recordId = request()->route('record')) {
                                        $query->where('reservation_id', '!=', $recordId);
                                    }
                                    
                                    if ($query->exists()) {
                                        $fail('This vehicle is already reserved for the selected date range.');
                                    }
                                }
                            };
                        }
                    ])
                    ->helperText('Must be after start date')
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $startDate = $get('start_date');
                        $endDate = $get('end_date');
                        $dailyRate = $get('daily_rate');
                    
                        if ($startDate && $endDate && $dailyRate) {
                            $days = (new \DateTime($endDate))->diff(new \DateTime($startDate))->days;
                            $days++;
                            $set('total_cost', $days * $dailyRate);
                        } else {
                            $set('total_cost', 0);
                        }
                    }),

                Forms\Components\TextInput::make('daily_rate')
                    ->label('Daily Rate')
                    ->readOnly()
                    ->prefix('LKR')
                    ->disabled(true),

                Forms\Components\TextInput::make('total_cost')
                    ->label('Total Cost')
                    ->readOnly()
                    ->prefix('LKR'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              // User ID
                TextColumn::make('reservation_id')
                  ->label('ID')
                  ->sortable()
                  ->searchable(),
                  
              TextColumn::make('user.name')
                  ->label('User Name')
                  ->sortable()
                  ->searchable(),

                    TextColumn::make('vehicle.registration_number')
                  ->label('Reg_Number')
                  ->sortable()
                  ->searchable(),
  
                  TextColumn::make('vehicle.brand')
                  ->label('Vehicle')
                  ->formatStateUsing(function ($state, Reservation $record) {
                      return "{$record->vehicle->brand} {$record->vehicle->model}";
                  })
                  ->sortable()
                  ->searchable(),
  
              // Start Date
              TextColumn::make('start_date')
                  ->label('Start Date')
                  ->default(now()->toDateString())
                    ->dateTime()
                  ->sortable(),
  
              // End Date
              TextColumn::make('end_date')
                  ->label('End Date')
                  ->dateTime()
                  ->sortable(),
  
              // Total Cost
              TextColumn::make('total_cost')
                  ->label('Total Cost')
                  ->money('LKR') // Format as currency
                  ->sortable(),
  
              // Status
              TextColumn::make('status')
                  ->label('Status')
                  ->badge()
                  ->sortable()
                    ->searchable()
                  ->color(fn (string $state): string => match ($state) {
                      'pending' => 'warning',
                      'confirmed' => 'success',
                      'cancelled' => 'danger',
                  }),
            ])
            ->filters([
                Filter::make('end_date_today')
                    ->label('Today Completed')
                    ->query(fn (Builder $query) => $query->whereDate('end_date', now()->toDateString())),
                
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ]),
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}