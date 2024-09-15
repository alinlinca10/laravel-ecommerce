<?php

namespace App\Models\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store\Product;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];  
    protected $table = 'mag__orders';

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeSearch($q, $value){
        return $q->where('products', 'LIKE', "%{$value}%")
        ->orWhere('notes', 'LIKE', "%{$value}%")
        ->orWhere('details', 'LIKE', "%{$value}%");
    }

    public function imgs()
    {
        if ($this->pictures) {
            return unserialize($this->pictures);
        } else {
            return null;
        }
    }

    public function order_products()
    {
        if ($this->products) {
            return unserialize($this->products);
        } else {
            return null;
        }
    }

    public function details()
    {
        if ($this->details) {
            return unserialize($this->details);
        } else {
            return null;
        }
    }

    public function statusDelivery()
    {
        $status = [
            'pending'           => 'Pending',
            'confirmed'         => 'Confirmed',
            'at_courier'        => 'Shipped',
            'delivered'         => 'Delivered',
            'pending_return'    => 'Pending return',
            'returned'          => 'Returned',
            'canceled'          => 'Cenceled',
        ];
        return $status[$this->status_delivery];
    }

    public function statusDeliveryColor($status = 'pending')
    {

        $color = [
            'pending'         => 'secondary',
            'read'            => 'info',
            'confirmed'       => 'primary',
            'at_courier'      => 'success',
            'delivered'       => 'success',
            'pending_return'   => 'warning',
            'returned'        => 'warning',
            'paid'            => 'success',
            'finish'          => 'success',
            'pending refound' => 'warning',
            'refound'         => 'warning',
            'canceled'        => 'danger',
        ];
        return $color[$this->status_delivery];
    }
}
