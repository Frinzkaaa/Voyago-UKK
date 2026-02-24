<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Booking::class, \App\Policies\BookingPolicy::class);

        // Product Gate for multiple models
        $productModels = [
            \App\Models\WisataSpot::class,
            \App\Models\Hotel::class,
            \App\Models\FlightTicket::class,
            \App\Models\TrainTicket::class,
            \App\Models\BusTicket::class,
        ];

        foreach ($productModels as $model) {
            \Illuminate\Support\Facades\Gate::policy($model, \App\Policies\ProductPolicy::class);
        }
    }
}
