<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImport extends Model
{
    
    protected $table = 'product_imports';

    protected $fillable = [
        'filename',
        'filepath',
        'status',
        'total_rows',
        'processed_rows',
        'failed_rows',
        'error_message',
    ];
    
        
        

}
