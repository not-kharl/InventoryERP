<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReorderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required',
            'department' => 'required|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required',
            'items.*.sku' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        // TODO: i-save sa database mo, hal.
        // ReorderRequest::create([...]);
        // tapos loop sa items para i-save yung bawat isa

        return response()->json([
            'message' => 'Reorder request sent to procurement.',
        ]);
    }
}