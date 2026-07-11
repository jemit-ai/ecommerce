<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use League\Csv\Reader;
use App\Models\Product;
use App\Models\ProductImport;
use App\Models\ProductImage;
use App\Events\ImportProgressUpdated;
use Illuminate\Support\Facades\Log;
use App\Notifications\ProductImportCompleted;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductImportCompletedMail;



class ImportProductChunkJob implements ShouldQueue
{
    use Queueable;

    //public $tries = 3;

    //public $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $rows,public array $header,public int $importId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        foreach($this->rows as $row){

             try {

                DB::transaction(function () use ($row) {

                        $name = trim($row[0]);
                        $sku = trim($row[1]);
                        $slug = Str::slug(trim($row[2]));
                        $description = trim($row[3]);
                        $price = $row[4];
                        $discount_price = $row[5];
                        $stock = $row[6];
                        //$images = explode("|", $row[7]);
                        $images = array_filter(array_map('trim', explode('|', $row[7])));

                        $product = Product::create([
                            'name' => $name,
                            'sku' => $sku,
                            'slug' => $slug,
                            'description' => $description,
                            'price' => $price,
                            'discount_price' => $discount_price,
                            'stock' => $stock,
                        ]);

                        $productId = $product->id;

                        foreach($images as $img){

                            ProductImage::create([
                                'product_id' => $productId,
                                'image' => $img,
                            ]);

                        }

                        ProductImport::whereId($this->importId)->increment('processed_rows');

                });

                
            }catch(\Throwable $e){

                Log::error($e->getMessage());

                ProductImport::whereId($this->importId)->increment('failed_rows');

                ProductImport::whereId($this->importId)->increment('processed_rows');

            }

        }

        $import = ProductImport::find($this->importId);

        $import->refresh();  

        $progress = round(
            ($import->processed_rows / $import->total_rows) * 100
        );


        //Brodcast Custom Event
        event(new ImportProgressUpdated(
            $this->importId,
            $progress,
            $import->status
        ));


       
        if ($progress == 100) {

            ProductImport::whereId($this->importId)->update([
                'status' => 'completed',
            ]);

            //Notification
            $user = User::find(1);
            Notification::send($user, new ProductImportCompleted($this->importId, 'Import completed successfully.'));

            //Email
            Mail::to($user->email)->queue(new ProductImportCompletedMail($import));

        }
     

    }
}
