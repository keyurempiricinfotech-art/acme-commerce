<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\Tag(name="Orders")
 */
class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orders)
    {
    }

    /**
     * @OA\Get(path="/api/v1/orders", tags={"Orders"}, summary="List authenticated customer orders")
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return OrderResource::collection(
            $request->user()->orders()->with(['items.product', 'shippingAddress'])->latest()->paginate(15)
        );
    }

    /**
     * @OA\Post(path="/api/v1/orders", tags={"Orders"}, summary="Place an order")
     */
    public function store(StoreOrderRequest $request): OrderResource
    {
        $order = $this->orders->place($request->user(), $request->validated());

        return new OrderResource($order->load(['items.product', 'shippingAddress']));
    }

    /**
     * @OA\Get(path="/api/v1/orders/{order}", tags={"Orders"}, summary="Show an order")
     */
    public function show(Request $request, Order $order): OrderResource
    {
        $this->authorize('view', $order);

        return new OrderResource($order->load(['items.product', 'shippingAddress']));
    }

    /**
     * @OA\Patch(path="/api/v1/orders/{order}", tags={"Orders"}, summary="Update order status")
     */
    public function update(UpdateOrderRequest $request, Order $order): OrderResource
    {
        $this->authorize('update', $order);

        return new OrderResource($this->orders->updateStatus($order, $request->validated('status')));
    }
}
