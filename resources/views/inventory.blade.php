<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Overview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root{
            --sidebar:#282885;
            --blue:#3f00b8;
            --green:#43a047;
            --yellow:#fdd835;
            --red:#e53935;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body {
            display: grid;
            grid-template-columns: 180px 1fr;
            height: 100vh;
            width: 100vw;
            background: #f5f5f5;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        .sidebar{
            width:180px;
            max-width:180px;
            min-width:180px;
            background:var(--sidebar);
            color:white;
            display:flex;
            flex-direction:column;
            padding:20px 10px;
            flex-shrink:0;
            height: 100vh;
        }

        .menu{
            width:50px;
            height:50px;
            border-radius:50%;
            background:#111;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 25px;
            flex-shrink: 0;
        }

        .nav-link{
            display: block;
            text-decoration: none;
            color:white;
            padding:12px;
            margin:4px 0;
            border-radius:5px;
            cursor:pointer;
            text-align:left;
            font-size:14px;
        }

        .nav-link:hover{
            background:rgba(255,255,255,.15);
        }

        .nav-link.active{
            background:white;
            color:var(--sidebar);
            font-weight:bold;
        }

        .main{
            height: 100vh;
            padding:20px;
            overflow-y:auto;
            overflow-x:hidden;
        }

        .header{
            display:flex;
            justify-content:space-between;
            margin-bottom:20px;
            align-items:center;
        }

        .search{
            flex:1;
            padding:12px 20px;
            border:none;
            border-radius:20px;
            background:#e0e0e0;
            outline:none;
        }

        .user{
            margin-left:15px;
            width:45px;
            height:45px;
            background:black;
            color:white;
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            flex-shrink:0;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="menu"></div>
        <nav>
            <a href="{{ url('/') }}" class="nav-link active">Inventory</a>
            <a href="{{ route('receipts.index') }}" class="nav-link">Stocks</a>
            <a href="#" class="nav-link">Reports</a>
            <a href="{{ url('/warehouse') }}" class="nav-link">Warehouse</a>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="main">
        <!-- Header -->
        <div class="header">
            <input type="text" placeholder="Search..." class="search">
            <div class="user"></div>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-5">Overview</h1>

        <!-- Summary Statistics Widgets Block -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
            <div class="bg-white border border-gray-200 rounded p-4 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Products</p>
                    <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $totalProducts }}</h3>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded p-4 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Pending Orders</p>
                    <h3 class="text-2xl font-black mt-1" style="color: var(--yellow);">{{ $pendingOrders }}</h3>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded p-4 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase">Low Stock Alerts</p>
                    <h3 class="text-2xl font-black mt-1" style="color: var(--red);">{{ $lowStockCount }}</h3>
                </div>
            </div>
        </div>

        <!-- Layout Grid Splits Into Left (Table) and Right (Recents) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">
            
            <!-- Table View Grid Panel (Takes up 2 Columns on large screens) -->
            <div class="lg:col-span-2 bg-white rounded border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-xs">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 font-bold">
                                <th class="p-3">SKU</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Product Name</th>
                                <th class="p-3">QTY</th>
                                <th class="p-3">Category ID</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600 font-medium">
                            @forelse($items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-bold text-gray-900">{{ $item->sku }}</td>
                                    <td class="p-3">
                                        @if($item->qty <= 10)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold border" style="background:#ffebee; color:var(--red); border-color:#ffcdd2;">Low Stock</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold border" style="background:#e8f5e9; color:var(--green); border-color:#c8e6c9;">In Stock</span>
                                        @endif
                                    </td>
                                    <td class="p-3 font-bold text-gray-900">{{ $item->productName }}</td>
                                    <td class="p-3">{{ $item->qty }}</td>
                                    <td class="p-3">{{ $item->categoryId }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400 italic bg-white">No products added yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity Panel -->
            <div class="bg-white rounded border border-gray-200 p-4 shadow-sm">
                <h2 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-base">Recent Activity</h2>
                <div class="space-y-3">
                    @forelse($activities ?? [] as $activity)
                        <div class="flex items-start gap-2.5 text-xs">
                            <div class="w-2 h-2 rounded-full mt-1 flex-shrink-0 
                                @if(($activity->type ?? '') === 'inventory' || ($activity->status ?? '') === 'Delivered') bg-green-500
                                @elseif(($activity->type ?? '') === 'low_stock') bg-red-500
                                @elseif(($activity->status ?? '') === 'Pending' || ($activity->status ?? '') === 'In Transit') bg-yellow-500
                                @else bg-blue-500 @endif">
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">{{ $activity->description ?? '' }}</p>
                                <span class="text-[10px] text-gray-400 font-medium">
                                    {{ isset($activity->created_at) ? $activity->created_at->diffForHumans() : '' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic py-2">No recent system updates recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</body>
</html>