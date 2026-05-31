<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
     /**
     * List all orders for the authenticated user.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('website.orders.index', compact('orders'));
    }

    /**
     * Show a single order detail page.
     * Route model binding resolves Order by {order} in the URL.
     */
    public function show(Order $order)
    {
        // Security: user can only view their own orders
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['items.product.images', 'transaction']);

    return view('website.orders.show', compact('order'));
    }
}
