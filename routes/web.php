<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ReceiptController;

Route::get('/receipts', [ReceiptController::class, 'index'])->name('receipts.index');
Route::post('/receipts', [ReceiptController::class, 'store'])->name('receipts.store');

Route::get('/', [InventoryController::class,'index']);
Route::delete('/inventory/{itemId}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
Route::put('/inventory/{itemId}', [InventoryController::class, 'update'])->name('inventory.update');

Route::get('/warehouse', [WarehouseController::class,'index'])
    ->name('warehouse');

    Route::post('/warehouse', [WarehouseController::class, 'store'])->name('warehouse.store');

    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
