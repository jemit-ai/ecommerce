<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\Order\OrderPlaced;
use App\Events\Order\OrderPaid;
use App\Events\Order\OrderCancelled;

use App\Listeners\OrderPlaced\ReserveInventory;
use App\Listeners\OrderPlaced\GenerateOrderNo;
use App\Listeners\OrderPlaced\CreateTimeline;
use App\Listeners\OrderPlaced\NotifyAdmin;
use App\Listeners\OrderPlaced\SendEmail;

use App\Listeners\OrderPaid\ReleaseInventory;
use App\Listeners\OrderPaid\CreateInvoice;
use App\Listeners\OrderPaid\CreateTimeline;
use App\Listeners\OrderPaid\NotifyAdmin;
use App\Listeners\OrderPaid\SendEmail;

use App\Listeners\OrderCancelled\AnalyticActivity;
use App\Listeners\OrderCancelled\CreateTimeline;
use App\Listeners\OrderCancelled\LogOrderActivity;
use App\Listeners\OrderCancelled\NotifyAdmin;
use App\Listeners\OrderCancelled\RefundPayment;
use App\Listeners\OrderCancelled\RestoreInventory;

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
        Event::listen(OrderPaid::class, CreateInvoice::class);
        Event::listen(OrderPaid::class, CreateTimeline::class);
        Event::listen(OrderPaid::class, NotifyAdmin::class);
        Event::listen(OrderPaid::class, SendEmail::class); 
            
        Event::listen(OrderCancelled::class, AnalyticActivity::class);
        Event::listen(OrderCancelled::class, CreateTimeline::class);
        Event::listen(OrderCancelled::class, LogOrderActivity::class);
        Event::listen(OrderCancelled::class, NotifyAdmin::class);
        Event::listen(OrderCancelled::class, RefundPayment::class); 
        Event::listen(OrderCancelled::class, RestoreInventory::class); 

    }
}
