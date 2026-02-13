<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCartMaster extends Model
{
    use HasFactory;

    protected $table = "cart_master";

    protected $primaryKey = "cart_id";

    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
    ];

    // Relationship: Cart belongs to User
    public function user()
    {
        return $this->belongsTo(UserMaster::class, 'user_id', 'userid');
    }

    // Relationship: Cart belongs to Item
    public function item()
    {
        return $this->belongsTo(ResItemMaster::class, 'item_id', 'item_id');
    }
}
