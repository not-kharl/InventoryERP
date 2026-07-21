<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Receipt;
use App\Models\Warehouse;

class ReportController extends Controller
{
    public function index()
    {
        $totalProducts = Inventory::count();
        $totalWarehouses = Warehouse::count();
        $lowStockItems = Inventory::where('qty', '<=', 10)->get();
        $deliveredOrders = Receipt::where('status', 'Delivered')->count();
        $pendingOrders = Receipt::where('status', 'Pending')->count();
        $inTransitOrders = Receipt::where('status', 'In Transit')->count();
        $recentReceipts = Receipt::orderByDesc('receiptDate')->take(10)->get();

        return view('reports', compact(
            'totalProducts', 'totalWarehouses', 'lowStockItems',
            'deliveredOrders', 'pendingOrders', 'inTransitOrders', 'recentReceipts'
        ));
    }
}
