<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use League\Csv\Reader;
use App\Models\Product;
use App\Models\ProductImport;
use App\Events\ImportProgressUpdated;
use Illuminate\Support\Facades\Log;
use App\Notifications\ProductImportCompleted;
use App\Models\User;
use Illuminate\Support\Facades\Notification;



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

                        /*file_put_contents(
                            storage_path('logs/test.log'),
                            "Processing Row =>" . $row[0] . "\n",
                            FILE_APPEND
                        ); */

                        Product::create([
                            'name' => $name,
                            'sku' => $sku,
                            'slug' => $slug,
                            'description' => $description,
                            'price' => $price,
                            'discount_price' => $discount_price,
                            'stock' => $stock,
                        ]);

                        
                        ProductImport::whereId($this->importId)->increment('processed_rows');

                });

                //DB::commit();


            }catch(\Throwable $e){

                Log::error($e->getMessage());

                //DB::rollBack();

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

        }
     

    }
}
