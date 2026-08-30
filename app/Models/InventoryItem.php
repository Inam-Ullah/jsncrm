<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'warranty_until' => 'date',
        'is_for_sale' => 'boolean',
    ];

    public function type()
    {
        return $this->belongsTo(InventoryItemType::class, 'inventory_item_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
