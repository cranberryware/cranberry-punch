<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;
use Filament\Forms\Components\DateTimePicker;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(in_array(config('app.env'), ['local', 'dev', 'development'])) {
            DB::listen(function($query) {
                Log::info(
                    $query->sql,
                    [
                        'bindings' => $query->bindings,
                        'time' => $query->time
                    ]
                );
            });
        }
        Filament::serving(function () {
            Filament::registerTheme(mix('css/open-attendance.css'));
        });
        DateTimePicker::configureUsing(fn (DateTimePicker $component) => $component->timezone(config('app.user_timezone')));
        TextColumn::configureUsing(fn (TextColumn $column) => $column->timezone(config('app.user_timezone')));
    }
}
