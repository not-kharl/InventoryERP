<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Warehouse Module</title>
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
            background:rgba(85, 1, 1, 0.15);
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

        .stat-card{
            background:white;
            border:1px solid #e5e7eb;
            border-radius:8px;
            padding:16px 20px;
            box-shadow:0 1px 2px rgba(0,0,0,.04);
            display:flex;
            align-items:center;
            gap:14px;
            width:fit-content;
        }

        .stat-icon{
            width:44px;
            height:44px;
            border-radius:8px;
            background:var(--sidebar);
            display:flex;
            align-items:center;
            justify-content:center;
            flex-shrink:0;
        }

        .stat-icon svg{
            width:22px;
            height:22px;
            stroke:white;
        }

        .stat-label{
            font-size:12px;
            font-weight:600;
            color:#6b7280;
            text-transform:uppercase;
            letter-spacing:.03em;
        }

        .stat-value{
            font-size:24px;
            font-weight:800;
            color:#1f2937;
            line-height:1.1;
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="menu"></div>
            <nav>
                <a href="{{ url('/') }}" class="nav-link">Inventory</a>
                <a href="{{ route('receipts.index') }}" class="nav-link">Stocks</a>
                <a href="#" class="nav-link">Reports</a>
                <a href="{{ route('warehouse') }}" class="nav-link active">Warehouse</a>
            </nav>
        </div>

    <!-- Main Content Area -->
    <div class="main">
        <!-- Top Header -->
        <div class="header">
            <input class="search" placeholder="Search...">
            <div class="user"></div>
        </div>

        <h1 class="text-2xl font-bold mb-5 text-gray-800">Warehouse Location and Tracking</h1>

        <!-- Content Grid: Form Left, Table Right -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">
            
            <!-- Left Side: Form Container -->
            <div class="bg-white p-4 rounded border border-gray-200 shadow-sm">
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-base">Add New Warehouse</h3>
                
                <form action="{{ route('warehouse.store') }}" method="POST" class="space-y-2 text-xs font-semibold text-gray-700">
                    @csrf
                    <div>
                        <label class="block mb-0.5">Warehouse Code</label>
                        <input type="text" name="warehouseCode" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                    </div>
                    
                    <div>
                        <label class="block mb-0.5">Zone</label>
                        <select name="zone" required class="w-full p-2 border border-gray-300 rounded bg-white font-normal text-gray-600 outline-none focus:border-[var(--sidebar)]">
                            <option value="" disabled selected>Select a zone</option>
                            <option value="1">1 - North Luzon</option>
                            <option value="2">2 - Metro Manila</option>
                            <option value="3">3 - Davao</option>
                            <option value="4">4 - Central Visayas</option>
                            <option value="5">5 - Zamboanga</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block mb-0.5">Capacitys Quantity</label>
                        <input type="number" step="0.01" name="capacityQty" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="w-full py-2 text-white font-bold rounded shadow-sm tracking-wide transition opacity-90 hover:opacity-100" style="background: var(--blue);">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Side: Data Table Container -->
            <div class="lg:col-span-2 bg-white rounded border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-gray-700 border-b border-gray-200 font-bold">
                                <th class="p-3">Location ID</th>
                                <th class="p-3">Warehouse Code</th>
                                <th class="p-3">Zone</th>
                                <th class="p-3">Capacity Qty</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600 font-medium">
                            @php
                                $zoneNames = [
                                    1 => 'North Luzon',
                                    2 => 'Metro Manila',
                                    3 => 'Davao',
                                    4 => 'Central Visayas',
                                    5 => 'Zamboanga',
                                ];
                            @endphp
                            @forelse($warehouses as $warehouse)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-bold text-gray-900">{{ $warehouse->locationId }}</td>
                                    <td class="p-3 font-bold text-gray-800">{{ $warehouse->warehouseCode }}</td>
                                    <td class="p-3">{{ $zoneNames[$warehouse->zone] ?? $warehouse->zone }}</td>
                                    <td class="p-3">{{ $warehouse->capacityQty }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-400 italic bg-white">
                                        No warehouses added yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Summary Tab: Total Warehouses -->
        <div class="mt-5">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 21h18M4 21V9l8-6 8 6v12M9 21v-6h6v6"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Total Warehouses</div>
                    <div class="stat-value">{{ $warehouses->count() }}</div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>