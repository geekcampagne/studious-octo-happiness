<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Parcel;
use Illuminate\Http\Request;

class CreateNewParcelController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order, Request $request)
    {
        $parcel = Parcel::create([
            'order_id' => $order->id,
            'carrier' => $request->get('carrier'),
        ]);

        response()->json($parcel);
    }
}
