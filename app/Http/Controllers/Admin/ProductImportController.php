<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImport;
use App\Jobs\ImportProductsJob;

class ProductImportController extends Controller
{
    //

    public function index()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
       
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->move(public_path('imports'), $filename);

        $import = ProductImport::create([
                'filename'=>$filename,
                'filepath'=>$path,
                'status'=>'pending',
        ]);

        ImportProductsJob::dispatch($import);
        
        return back()->with('success','Import Started');
        
    }
    
    
}
