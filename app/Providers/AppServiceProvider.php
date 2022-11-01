<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\ServiceProvider;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Foundation\Vite;

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
            Filament::registerTheme(
                app(Vite::class)('resources/scss/app.scss'),
            );
        });
        DateTimePicker::configureUsing(fn (DateTimePicker $component) => $component->timezone(config('app.user_timezone')));
        TextColumn::configureUsing(fn (TextColumn $column) => $column->timezone(config('app.user_timezone')));
        Blade::stringable(function(\Illuminate\Support\Carbon $dateTime) {
            return $dateTime->format(config('app.user_datetime_format'));
        });
        FilamentSocialiteFacade::setCreateUserCallback(function (SocialiteUserContract $oauthUser, FilamentSocialite $socialite) {
            $created_user = $socialite->getUserModelClass()::create([
                'name' => $oauthUser->getName(),
                'email' => $oauthUser->getEmail(),
                'password' => Hash::make(md5(uniqid())),
            ])->assignRole('employee');
            $created_user->markEmailAsVerified();
            return $created_user;
        });
    }
}
