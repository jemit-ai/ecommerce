<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\ProductImport;
use Illuminate\Support\Facades\Log;
use App\Jobs\ImportProductChunkJob;



class ImportProductsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    public $productImport;

    
    public function __construct(ProductImport $productImport)
    {
        $this->productImport = $productImport;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $this->productImport->update([
            'status' => 'processing',
        ]);

        $file = public_path('imports/' . $this->productImport->filename);


        $rows = array_map('str_getcsv',
            file($file)
        );

        file_put_contents(
            storage_path('logs/test.log'),
            "Found " . count($rows) . " rows\n",
            FILE_APPEND
        );
        
        $header = array_shift($rows);

        $this->productImport->update([
            'total_rows'=>count($rows)
        ]);

        $tep=1;
        foreach(array_chunk($rows,100) as $chunk){


            ImportProductChunkJob::dispatch(
                $chunk,
                $header,
                $this->productImport->id
            );

            /*file_put_contents(
                storage_path('logs/test.log'),
                $tep." :-Dispatching\n",
                FILE_APPEND
            );*/

            $tep++;
        }

        $import = ProductImport::find($this->productImport->id);

        file_put_contents(
            
            storage_path('logs/test.log'),
            "Processed " . $import->processed_rows . "\n",
            FILE_APPEND
        );
 
        
        file_put_contents(
            storage_path('logs/test.log'),
            "End started\n",
            FILE_APPEND
        );


    }
}
