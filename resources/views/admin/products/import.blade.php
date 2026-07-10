@extends('layouts.admin')

@section('title', 'Import Products')

@section('content')

<script>
        document.addEventListener('DOMContentLoaded', () => {
            Echo.channel('product-progress')
                .listen('.progress.updated', (e) => {

                    const progressContainer = document.getElementById('progressContainer');

                    if (e.progress > 0 && e.progress < 100) {
                        progressContainer.style.display = 'block';
                    }

                    //console.log(e);
                    document.getElementById('progressBar').value = e.progress;
                    document.getElementById('progressText').innerText = e.progress + '%';

                });
        });
</script>

<div class="mx-auto max-w-5xl">
    <!-- Header -->
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Import Product Catalog</h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Upload your CSV files to import or update inventory information in bulk.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ asset('sample/products.csv') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-2.5 text-xs sm:text-sm font-semibold text-emerald-700 hover:bg-emerald-100 transition-colors">
                <i class="fa-solid fa-file-arrow-down"></i>
                Download Sample CSV
            </a>
        </div>
    </div>


    <div id="progressContainer" style="display:none;">
        <progress id="progressBar" value="0" max="100"  class="w-full h-4 rounded-full overflow-hidden">
        </progress>
        <span id="progressText">0%</span>
    </div>

  
    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50/50 p-4 text-sm text-emerald-800 shadow-sm flex gap-3 items-start">
            <i class="fa-solid fa-circle-check text-lg text-emerald-600 mt-0.5"></i>
            <div class="flex-1">
                <p class="font-semibold">Success</p>
                <p class="text-emerald-700/90 mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50/50 p-4 text-sm text-red-800 shadow-sm flex gap-3 items-start">
            <i class="fa-solid fa-circle-exclamation text-lg text-red-600 mt-0.5"></i>
            <div class="flex-1">
                <p class="font-semibold">Please fix the following validation errors:</p>
                <ul class="mt-2 list-inside list-disc space-y-1 text-red-700/95">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Import Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('products.import.post') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <!-- Drag & Drop / Upload -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            CSV File <span class="text-red-500">*</span>
                        </label>

                        <div class="group relative flex justify-center rounded-2xl border-2 border-dashed border-slate-300 px-6 py-10 bg-slate-50/50 hover:bg-slate-50/80 hover:border-indigo-400 transition-all cursor-pointer @error('csv_file') border-red-300 bg-red-50/10 @enderror"
                             onclick="document.getElementById('csv_file').click()">
                            
                            <div class="text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-500 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors mb-3">
                                    <i class="fa-solid fa-file-csv text-2xl"></i>
                                </div>
                                <div class="mt-2 flex text-sm justify-center leading-6 text-slate-600">
                                    <span class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                                        Click to upload
                                    </span>
                                    <p class="pl-1 text-slate-500">or drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-400 mt-1" id="file-chosen-text">CSV files only, up to 10MB</p>
                            </div>
                        </div>

                        <input id="csv_file"
                               type="file"
                               name="csv_file"
                               class="hidden"
                               accept=".csv"
                               onchange="showFileName(this)">

                        @error('csv_file')
                            <p class="mt-2 text-xs text-red-600 font-medium">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Configuration Options -->
                    <div class="mb-6 border-t border-slate-100 pt-5">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Import Settings</h4>
                        
                        <div class="space-y-4">
                            <!-- Option: Has Header -->
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600/30 accent-indigo-600"
                                       type="checkbox"
                                       name="has_header"
                                       value="1"
                                       checked>
                                <div>
                                    <span class="text-sm font-semibold text-slate-800">CSV contains header row</span>
                                    <p class="text-xs text-slate-400 mt-0.5">Check this if the first line of your file contains column labels.</p>
                                </div>
                            </label>

                            <!-- Option: Overwrite -->
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input class="mt-1 h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600/30 accent-indigo-600"
                                       type="checkbox"
                                       name="overwrite"
                                       value="1">
                                <div>
                                    <span class="text-sm font-semibold text-slate-800">Update existing products</span>
                                    <p class="text-xs text-slate-400 mt-0.5">Matches products by SKU. Overwrites existing values if found.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3 border-t border-slate-100 pt-5 mt-6">
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 transition-colors cursor-pointer">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            Import Products
                        </button>

                        <a href="{{ route('products.import') }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 hover:bg-slate-50 transition-colors">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Guidelines -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-3">Quick Instructions</h3>
                <ol class="list-decimal list-inside text-xs text-slate-500 space-y-3.5 leading-relaxed">
                    <li>Download the <a href="{{ asset('sample/products.csv') }}" class="font-semibold text-indigo-600 hover:underline">sample CSV file</a> to view the format layout.</li>
                    <li>Ensure columns are named exactly as shown in the specifications.</li>
                    <li>The price fields should not contain currency symbols (e.g. use <code class="bg-slate-50 border border-slate-200 px-1 py-0.5 rounded font-mono text-2xs text-slate-800">79999</code>, not <code class="bg-slate-50 border border-slate-200 px-1 py-0.5 rounded font-mono text-2xs text-slate-800">$79,999</code>).</li>
                    <li>Images can be hosted URL addresses. Make sure the URLs are public.</li>
                </ol>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-slate-900 p-6 shadow-lg text-white">
                <div class="flex items-center gap-3 mb-4">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-500 text-white">
                        <i class="fa-solid fa-circle-question"></i>
                    </span>
                    <h3 class="text-sm font-bold uppercase tracking-wider">Need Help?</h3>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed mb-4">
                    If you run into import timeout issues with very large datasets (more than 10,000 products), we recommend slicing your CSV file into smaller batches.
                </p>
                <a href="mailto:support@example.com" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors">
                    Contact Database Admin <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Schema details table -->
    <div class="mt-8 rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4">
            <h3 class="text-sm font-bold text-slate-950 uppercase tracking-wider">CSV Columns Specification</h3>
            <p class="text-xs text-slate-500 mt-1">Please ensure your columns match these designations exactly.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs text-slate-500">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 font-semibold text-slate-700 uppercase tracking-wider text-2xs">
                        <th class="px-6 py-3.5">Column Name</th>
                        <th class="px-6 py-3.5">Required</th>
                        <th class="px-6 py-3.5">Format/Type</th>
                        <th class="px-6 py-3.5">Description</th>
                        <th class="px-6 py-3.5">Example</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white font-medium">
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">sku</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-0.5 text-2xs font-semibold text-indigo-700 border border-indigo-150">Yes</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">String (Unique)</td>
                        <td class="px-6 py-3.5 text-slate-450">Stock Keeping Unit code identifying the product.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">SKU001</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">name</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-0.5 text-2xs font-semibold text-indigo-700 border border-indigo-150">Yes</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">String</td>
                        <td class="px-6 py-3.5 text-slate-450">The public label/name of the product.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">iPhone 16</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">slug</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-0.5 text-2xs font-semibold text-slate-600 border border-slate-200">No</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">String</td>
                        <td class="px-6 py-3.5 text-slate-450">URL slug. Automatically generated if left empty.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">iphone-16</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">description</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-0.5 text-2xs font-semibold text-slate-600 border border-slate-200">No</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">Text</td>
                        <td class="px-6 py-3.5 text-slate-450">Full description of the product catalog. HTML allowed.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">Latest Apple Phone</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">price</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-0.5 text-2xs font-semibold text-indigo-700 border border-indigo-150">Yes</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">Numeric (Decimal)</td>
                        <td class="px-6 py-3.5 text-slate-450">Base standard price of the item.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">79999</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">sale_price</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-0.5 text-2xs font-semibold text-slate-600 border border-slate-200">No</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">Numeric (Decimal)</td>
                        <td class="px-6 py-3.5 text-slate-450">Discounted product price. Should be lower than base price.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">74999</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">stock</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-0.5 text-2xs font-semibold text-indigo-700 border border-indigo-150">Yes</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">Integer</td>
                        <td class="px-6 py-3.5 text-slate-450">Initial quantity in stock.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">100</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">brand</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-0.5 text-2xs font-semibold text-slate-600 border border-slate-200">No</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">String</td>
                        <td class="px-6 py-3.5 text-slate-450">Brand or company name.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">Apple</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">category</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-0.5 text-2xs font-semibold text-slate-600 border border-slate-200">No</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">String</td>
                        <td class="px-6 py-3.5 text-slate-450">Primary category name.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-800">Mobile</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-slate-900">image</td>
                        <td class="px-6 py-3.5"><span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-0.5 text-2xs font-semibold text-slate-600 border border-slate-200">No</span></td>
                        <td class="px-6 py-3.5 font-mono text-2xs">String (URL)</td>
                        <td class="px-6 py-3.5 text-slate-450">Public URL of the product image display.</td>
                        <td class="px-6 py-3.5 font-mono text-2xs text-slate-850 truncate max-w-[200px]" title="https://example.com/images/iphone16.jpg">https://example.com/images/iphone16.jpg</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showFileName(input) {
        const text = document.getElementById('file-chosen-text');
        if (input.files && input.files[0]) {
            text.innerHTML = `<span class="font-semibold text-indigo-650 bg-indigo-50 border border-indigo-150 rounded-xl px-3 py-1.5 inline-flex items-center gap-2 mt-2 shadow-2xs"><i class="fa-solid fa-file-circle-check text-indigo-600"></i> ${input.files[0].name}</span>`;
        } else {
            text.textContent = 'CSV files only, up to 10MB';
        }
    }
</script>
@endsection