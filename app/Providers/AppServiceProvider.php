<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\Order\OrderPlaced;
use App\Listeners\OrderPlaced\UpdateInventoryListener;
use App\Listeners\OrderPlaced\SendOrderEmailListener;
use App\Listeners\OrderPlaced\GenerateInvoiceListener;


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
        //
        Event::listen(OrderPlaced::class, [UpdateInventoryListener::class, 'handle']);
        //Event::listen(OrderPlaced::class, [SendOrderEmailListener::class, 'handle']);
        Event::listen(OrderPlaced::class, [GenerateInvoiceListener::class, 'handle']);
        
    }
}
