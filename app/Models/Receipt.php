<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';
    protected $primaryKey = 'receiptId';

    protected $fillable = [
        'poId', 
        'poNumber', 
        'supplierName', 
        'receiptDate', 
        'receivedBy',
        'status'
    ];
}
