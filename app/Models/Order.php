<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'address',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'payment_proof',
        'delivery_method',
        'user_id',
        'shipping_cost',
        'order_number',
        'order_date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $today = Carbon::now()->toDateString();

            $lastOrder = Order::whereDate('order_date', $today)
                ->orderBy('order_number', 'desc')
                ->first();

            if ($lastOrder && $lastOrder->order_number) {
                $lastNumber = intval($lastOrder->order_number);
                $model->order_number = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $model->order_number = '001';
            }

            $model->order_date = $today;
        });
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
