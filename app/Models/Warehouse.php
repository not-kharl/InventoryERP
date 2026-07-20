<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';
    protected $primaryKey = 'locationId';

    protected $fillable = [
        'warehouseCode', 
        'zone', 
        'capacityQty'
    ];
}
