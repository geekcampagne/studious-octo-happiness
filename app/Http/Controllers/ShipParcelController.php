<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTrackingRequest;
use App\Models\Parcel;

class ShipParcelController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Parcel $parcel, AddTrackingRequest $request)
    {
        $parcel->tracking_number = $request->validated('tracking_number');
        $parcel->shipping_date = now();
        $parcel->save();

        return response()->json($parcel);
    }
}
