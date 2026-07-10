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

        /*foreach($this->rows as $row){

            DB::beginTransaction();

            try{

                $product=[ 
                    'name' => trim($row[1]),
                    'slug' => Str::slug(trim($row[1])),
                    'description' => trim($row[2]),
                    'price' => $row[3],
                    'stock' => $row[4],
                    'status' => $row[5],
                    'category_id' => $row[6],
                    'supplier_id' => $row[7],
                ];

                $name = trim($row[0]);
                $sku = trim($row[1]);
                $slug = Str::slug(trim($row[2]));
                $description = trim($row[3]);
                $price = $row[4];
                $sale_price = $row[5];
                $stock = $row[6];

                Product::updateOrCreate([
                    'name' => $name,
                    'sku' => $sku,
                    'slug' => $slug,
                    'description' => $description,
                    'price' => $price,
                    'sale_price' => $sale_price,
                    'stock' => $stock,
                ]);

                ProductImport::whereId($importId)->increment('success_rows');

                ProductImport::whereId($importId)->increment('processed_rows');
                
                DB::commit();

            }catch(\Exception $e){

                DB::rollBack();

                ProductImport::whereId($importId)->increment('failed_rows');

                ProductImport::whereId($importId)->increment('processed_rows');

                
            } 

            

        }*/

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

        /*file_put_contents(
            storage_path('logs/test.log'),
            "Processed Chunk =>" . $import->processed_rows . "\n",
            FILE_APPEND
        );*/

       
        $progress = round(
            ($import->processed_rows / $import->total_rows) * 100
        );


        /*file_put_contents(
            storage_path('logs/test.log'),
            "Progress Chunk =>" . $progress . "\n",
            FILE_APPEND
        );*/

        //Brodcast Custom Event
        event(new ImportProgressUpdated(
            $this->importId,
            $progress,
            $import->status
        ));


        //Notification
        $user = User::find(1);
        Notification::send($users, new ProductImportCompleted($this->importId, 'Import completed successfully.'));

        

        if ($progress == 100) {

            ProductImport::whereId($this->importId)->update([
                'status' => 'completed',
            ]);

        }
     

    }
}
