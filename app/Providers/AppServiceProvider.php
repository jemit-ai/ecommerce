<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\Order\OrderPlaced;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderCancelled;

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
        
        Event::listen(OrderPlaced::class, \App\Listeners\OrderPlaced\ReserveInventory::class);
        Event::listen(OrderPlaced::class, \App\Listeners\OrderPlaced\GenerateOrderNo::class);
        Event::listen(OrderPlaced::class, \App\Listeners\OrderPlaced\CreateTimeline::class);
        Event::listen(OrderPlaced::class, \App\Listeners\OrderPlaced\NotifyAdmin::class);
        Event::listen(OrderPlaced::class, \App\Listeners\OrderPlaced\SendEmail::class);  

        Event::listen(OrderPaid::class, \App\Listeners\OrderPaid\ReleaseInventory::class);
        Event::listen(OrderPaid::class, \App\Listeners\OrderPaid\CreateInvoice::class);
        Event::listen(OrderPaid::class, \App\Listeners\OrderPaid\CreateTimeline::class);
        Event::listen(OrderPaid::class, \App\Listeners\OrderPaid\NotifyAdmin::class);
        Event::listen(OrderPaid::class, \App\Listeners\OrderPaid\SendEmail::class); 
            
        Event::listen(OrderCancelled::class, \App\Listeners\OrderCancelled\AnalyticActivity::class);
        Event::listen(OrderCancelled::class, \App\Listeners\OrderCancelled\CreateTimeline::class);
        Event::listen(OrderCancelled::class, \App\Listeners\OrderCancelled\LogOrderActivity::class);
        Event::listen(OrderCancelled::class, \App\Listeners\OrderCancelled\NotifyAdmin::class);
        Event::listen(OrderCancelled::class, \App\Listeners\OrderCancelled\RefundPayment::class); 
        Event::listen(OrderCancelled::class, \App\Listeners\OrderCancelled\RestoreInventory::class); 

    }
}
