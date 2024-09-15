<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    public static function statusDelivery()
    {
        $status = [
            'pending'           => 'Pending',
            'confirmed'         => 'Confirmed',
            'at_courier'        => 'Shipped',
            'delivered'         => 'Delivered',
            'pending_return'     => 'Pending return',
            'returned'          => 'Returned',
        ];
        return $status;
    }

    public static function getStatusDelivery($val = 'pending')
    {
        $status = [
            'pending'           => 'Pending',
            'confirmed'         => 'Confirmed',
            'at_courier'        => 'Shipped',
            'delivered'         => 'Delivered',
            'pending_return'     => 'Pending return',
            'returned'          => 'Returned',
        ];
        return $status[$val];
    }
}
