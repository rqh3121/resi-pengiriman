<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Shipment;

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
        // Share sidebar stats ke semua view yang menggunakan layout 'layouts.app'
        View::composer('layouts.app', function ($view) {
            $view->with('sidebarStats', [
                'today_shipments' => Shipment::whereDate('created_at', today())->count(),
                'pending_resi'    => Shipment::whereNull('resi_number')->orWhereNull('expedition')->count(),
                'total_packages'  => Shipment::sum('package_count'),
            ]);
        });
    }
}