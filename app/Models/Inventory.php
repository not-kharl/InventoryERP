<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';
    protected $primaryKey = 'itemId';
    
    protected $fillable = [
        'sku', 
        'description', 
        'categoryId', 
        'productName',
        'qty'
    ];
}
