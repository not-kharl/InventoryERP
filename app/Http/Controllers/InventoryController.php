<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Receipt;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        if ($search) {
            $items = Inventory::where('productName', 'LIKE', "%{$search}%")
                            ->orWhere('sku', 'LIKE', "%{$search}%")
                            ->get();
        } else {
            $items = Inventory::all();
        }

        // Dynamic Calculations
        $totalProducts = Inventory::count();
        $pendingOrders = Receipt::whereIn('status', ['Pending', 'In Transit'])->count();
        $lowStockCount = Inventory::where('qty', '<=', 10)->count();
        
        // 1. Initialize an empty collection to hold unified activity feeds
        $activities = collect();

        // 2. Fetch recently added inventory items
        Inventory::latest()->take(3)->get()->each(function($item) use ($activities) {
            $activities->push((object)[
                'type' => 'inventory',
                'status' => null,
                'description' => "New product added: {$item->productName} (SKU: {$item->sku})",
                'created_at' => $item->created_at
            ]);
        });

        // 3. Fetch recent receipts (Pending, In Transit, Delivered)
        Receipt::whereIn('status', ['Pending', 'In Transit', 'Delivered'])
            ->latest()
            ->take(3)
            ->get()
            ->each(function($receipt) use ($activities) {
                $activities->push((object)[
                    'type' => 'receipt',
                    'status' => $receipt->status,
                    'description' => "Receipt #{$receipt->poNumber} marked as {$receipt->status}",
                    'created_at' => $receipt->created_at
                ]);
            });

        // 4. Fetch current items causing low stock warnings
        Inventory::where('qty', '<=', 10)->latest()->take(3)->get()->each(function($item) use ($activities) {
            $activities->push((object)[
                'type' => 'low_stock',
                'status' => null,
                'description' => "Low stock alert: {$item->productName} dropped to {$item->qty} QTY",
                'created_at' => $item->updated_at
            ]);
        });

        // 5. Fetch recently added warehouses
        Warehouse::latest()->take(3)->get()->each(function($warehouse) use ($activities) {
            $activities->push((object)[
                'type' => 'warehouse',
                'status' => null,
                'description' => "New warehouse added: {$warehouse->name}",
                'created_at' => $warehouse->created_at
            ]);
        });

        // 6. Sort by newest timestamp and limit to top 5 logs
        $activities = $activities->sortByDesc('created_at')->take(5);
        
        return view('inventory', compact(
            'items', 'search', 'totalProducts', 'pendingOrders', 
            'lowStockCount', 'activities'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:inventories,sku',
            'productName' => 'required|string',
            'description' => 'required|string',
            'categoryId' => 'required|integer',
            'qty' => 'required|integer|min:0',
        ]);

        Inventory::create($validated);
        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function update(Request $request, $itemId)
    {
        $item = Inventory::findOrFail($itemId);

        $validated = $request->validate([
            'sku' => 'required|unique:inventories,sku,' . $itemId . ',itemId',
            'productName' => 'required|string',
            'description' => 'required|string',
            'categoryId' => 'required|integer',
        ]);

        $item->update($validated);
        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy($itemId)
    {
        $item = Inventory::findOrFail($itemId);
        $item->delete();
        
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}