<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderPayRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;


/**
 * @OA\Info(
 *     title="Order Payment API",
 *     version="1.0.0",
 *     description="API for processing order payments and updating user points"
 * )
 */

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    /**
     * @OA\Post(
     *     path="/api/orders/{orderId}/pay",
     *     summary="Pay an order and update user points",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="orderId",
     *         in="path",
     *         required=true,
     *         description="ID of the order to pay",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order paid successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="order", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="total_price", type="string", example="50.00"),
     *                 @OA\Property(property="status", type="string", example="paid"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             ),
     *             @OA\Property(property="new_points", type="integer", example=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid order ID or order not pending",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Order status must be pending to pay"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="orderId", type="array", @OA\Items(type="string", example="The selected order id is invalid."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */

    public function pay(OrderPayRequest $request): JsonResponse
    {
        try {
            $result = $this->orderService->payOrder($request->orderId);

            return response()->json([
                'success' => true,
                'order' => $result['order'],
                'user_points' => $result['user_points'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}


