<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductScanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product, ScanProductRequest $request)
    {
        //KeyNetic_V1_AAAAAA
        [$model, $version, $SN] = explode('_', $request->validated('serialized_scan'));
        $product->serial_number = $SN;
        $product->save();
    }
}
