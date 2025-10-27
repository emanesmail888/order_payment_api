<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function findOrderById($id)
    {
        return Order::findOrFail($id);
    }

    public function updateOrderStatus(Order $order, string $status)
    {
        $order->status = $status;
        $order->save();
        return $order;
    }

    public function getUserById($userId)
    {
        return User::findOrFail($userId);
    }

    public function updateUserPoints(User $user, int $pointsToAdd)
    {
        $user->points += $pointsToAdd;
        $user->save();
        return $user;
    }


}
