<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;

class ImportProduct extends Controller
{
    public function import()
    {
        return view('dashboard.products.import');
    }

    public function store(Request $request)
    {

        $request->validate([
            'count' => 'required|integer|min:50|max:10000',
        ]);

        $job = new ImportProducts($request->count);
        dispatch($job)->onQueue('imports')->onConnection('database');
        return redirect()->route('dashboard.product.index')->with('success', 'Product import has been started. You will be notified once it is complete.');
    }
}
