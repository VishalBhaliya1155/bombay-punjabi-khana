<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class ResItemMaster extends Model
{
    use HasFactory;

    protected $table      = 'res_item_master';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'name',
        'cat_id',
        'price',
    ];
    // Relationship: Item belongs to Category
    public function category()
    {
        return $this->belongsTo(ResCategoryMaster::class, 'cat_id', 'category_id');
    }
}
