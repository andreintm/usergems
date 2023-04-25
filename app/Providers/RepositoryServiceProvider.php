<?php

namespace App\Providers;

use App\Repositories\AttendeeRepository;
use App\Repositories\EmailRepository;
use App\Repositories\EventRepository;
use App\Repositories\Interfaces\AttendeeRepositoryInterface;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(AttendeeRepositoryInterface::class, AttendeeRepository::class);
        $this->app->bind(EmailRepositoryInterface::class, EmailRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
