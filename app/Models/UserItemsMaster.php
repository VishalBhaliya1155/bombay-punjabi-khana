<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserItemsMaster extends Model
{
    use HasFactory;

    protected $table = "order_master";

    protected $primaryKey = "order_id";

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
    ];

    // Relationship: Order belongs to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
