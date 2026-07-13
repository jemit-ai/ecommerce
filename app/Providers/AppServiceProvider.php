<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\Order\OrderPlaced;

use App\Listeners\OrderPlaced\ReserveInventory;
use App\Listeners\OrderPlaced\GenerateOrderNo;
use App\Listeners\OrderPlaced\CreateTimeline;
use App\Listeners\OrderPlaced\NotifyAdmin;
use App\Listeners\OrderPlaced\SendEmail;


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
        //Event::listen(OrderPlaced::class, [UpdateInventoryListener::class, 'handle']);
        //Event::listen(OrderPlaced::class, [SendOrderEmailListener::class, 'handle']);
        //Event::listen(OrderPlaced::class, [GenerateInvoiceListener::class, 'handle']);
        
        Event::listen(OrderPlaced::class, ReserveInventory::class);
        Event::listen(OrderPlaced::class, GenerateOrderNo::class);
        Event::listen(OrderPlaced::class, CreateTimeline::class);
        Event::listen(OrderPlaced::class, NotifyAdmin::class);
        Event::listen(OrderPlaced::class, SendEmail::class);  

        Event::listen(OrderPaid::class, ReleaseInventory::class);
        Event::listen(OrderPaid::class, GenerateInvoice::class);
        Event::listen(OrderPaid::class, CreateTimeline::class);
        Event::listen(OrderPaid::class, NotifyAdmin::class);
        Event::listen(OrderPaid::class, SendEmail::class); 
            

    }
}
