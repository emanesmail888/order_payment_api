<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function payOrder($orderId)
    {
        return DB::transaction(function () use ($orderId) {
            $order = $this->orderRepository->findOrderById($orderId);

            if ($order->status !== 'pending') {
                // throw new Exception('Order must be in pending status to be paid', 400);
                return response()->json(['error' => 'Order is not in pending status'], 400);

            }

            // Update order status
            $order = $this->orderRepository->updateOrderStatus($order, 'paid');

            // Calculate points
            $points = (int) $order->total_price;
            if ($order->total_price >= 100) {
                $points += 10;  // Bonus
            }

            // Update user points
            $user = $this->orderRepository->getUserById($order->user_id);
            $user = $this->orderRepository->updateUserPoints($user, $points);

            return [
                'order' => $order,
                'user_points' => $user->points,
            ];
        });
    }
}
