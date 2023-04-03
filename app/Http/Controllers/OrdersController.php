<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $orderBy = $request->get('order_by', 'order_date');
        $orderDirection = $request->get('order_direction', 'desc');

        return Order::join('customers', 'customers.id', '=', 'orders.customer_id')
            ->orderBy($orderBy, $orderDirection)
            ->paginate(
                $request->get('per_page', 2)
            );
    }
}
