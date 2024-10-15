<?php

namespace App\Providers;

use App\Repositories\DeliveryAssignmentRepository;
use App\Repositories\DeliveryAssignmentRepositoryInterface;
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
        $this->app->bind(DeliveryAssignmentRepositoryInterface::class, DeliveryAssignmentRepository::class);
    }
}
