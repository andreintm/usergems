<?php

namespace App\Providers;

use App\Interfaces\EmailServiceInterface;
use App\Services\Calendar\CalendarApiService;
use App\Services\Calendar\Interfaces\CalendarApiInterface;
use App\Services\JsonEmailService;
use App\Services\Person\Interfaces\PersonApiInterface;
use App\Services\Person\PersonApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(CalendarApiInterface::class, fn () => new CalendarApiService(
            config('services.calendar.url')
        ));

        $this->app->bind(PersonApiInterface::class, fn () => new PersonApiService(
            config('services.person_data.url'), config('services.person_data.key')
        ));

        $this->app->bind(EmailServiceInterface::class, JsonEmailService::class);
    }
}
