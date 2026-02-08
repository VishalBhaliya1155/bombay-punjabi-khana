<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResOrderItemsMaster extends Model
{
    use HasFactory;

    protected $table = "order_items_master";

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'price'
    ];

    // Order belongs to Order
    public function order()
    {
        return $this->belongsTo(UserItemsMaster::class, 'order_id', 'order_id');
    }

    // Item belongs to ResItem
    public function item()
    {
        return $this->belongsTo(UserItemMaster::class, 'item_id', 'item_id');
    }
}
