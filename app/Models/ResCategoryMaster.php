<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResCategoryMaster extends Model
{
    use HasFactory;

    protected $table      = 'res_category_master';
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'name',
    ];

    // Relationship: Category has many Items
    public function items()
    {
        return $this->hasMany(UserItemMaster::class, 'category_id', 'category_id');
    }
}
