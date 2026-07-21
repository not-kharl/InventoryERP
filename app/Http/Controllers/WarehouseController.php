<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        // Fetch all warehouses from the database
        $warehouses = Warehouse::all();
        
        return view('warehouse', compact('warehouses'));
    }

    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'warehouseCode' => 'required|string|unique:warehouses,warehouseCode',
            'zone' => 'required|integer|between:1,5',
            'capacityQty' => 'required|numeric',
        ]);

        // Create the warehouse record
        Warehouse::create($validated);

        return redirect()->back()->with('success', 'Warehouse added successfully!');
    }
}