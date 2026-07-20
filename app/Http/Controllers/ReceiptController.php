<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Inventory;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = Receipt::orderBy('created_at', 'desc')->get();
        
        // Dynamic counts for receipt page widgets
        $stockInCount = Receipt::where('status', 'Delivered')->count();
        $stockOutCount = 0; // Placeholder or wire up to a custom logic
        $transferCount = Receipt::where('status', 'In Transit')->count();
        $totalTransactions = Receipt::count();

        return view('receipt', compact('receipts', 'stockInCount', 'stockOutCount', 'transferCount', 'totalTransactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'poId' => 'required|integer',
            'poNumber' => 'required|string',
            'supplierName' => 'required|string',
            'receivedBy' => 'required|integer',
            'status' => 'required|string|in:Pending,In Transit,Delivered',
        ]);

        Receipt::create($validated);

        return redirect()->back()->with('success', 'Receipt logged successfully!');
    }
}