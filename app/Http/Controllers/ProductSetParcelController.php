<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Models\Product;

class ProductSetParcelController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product, Parcel $parcel)
    {
        $product->parcel()->associate($parcel)->save();
    }
}
