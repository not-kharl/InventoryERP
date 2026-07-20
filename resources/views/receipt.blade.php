<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Transactions</title>
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
            <a href="{{ url('/') }}" class="nav-link">Inventory</a>
            <a href="{{ route('receipts.index') }}" class="nav-link active">Stocks</a>
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

        <h1 class="text-2xl font-bold text-gray-800 mb-5">Stock Transactions</h1>

        <!-- Validation Errors (shows why a form silently failed to save) -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 text-xs p-3 rounded mb-3">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-xs p-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Content Layout Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">
            
            <!-- Forms Column Wrapper (Left Side) -->
            <div>
                <!-- Log Form Container -->
                <div class="bg-white rounded border border-gray-200 p-4 shadow-sm">
                    <h2 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-base">New Stock Transaction</h2>
                    <form action="{{ route('receipts.store') }}" method="POST" class="space-y-2 text-xs font-semibold text-gray-700">
                        @csrf
                        <div>
                            <label class="block mb-0.5">PO ID</label>
                            <input type="number" name="poId" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                        </div>
                        <div>
                            <label class="block mb-0.5">PO Number</label>
                            <input type="text" name="poNumber" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                        </div>
                        <div>
                            <label class="block mb-0.5">Supplier Name</label>
                            <input type="text" name="supplierName" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                        </div>
                        <div>
                            <label class="block mb-0.5">Received By (User ID)</label>
                            <input type="number" name="receivedBy" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                        </div>
                        <div>
                            <label class="block mb-0.5">Status</label>
                            <select name="status" required class="w-full p-2 border border-gray-300 rounded bg-white font-normal text-gray-600 outline-none focus:border-[var(--sidebar)]">
                                <option value="Pending">Pending</option>
                                <option value="In Transit">In Transit</option>
                                <option value="Delivered">Delivered</option>
                            </select>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="w-full py-2 text-white font-bold rounded shadow-sm tracking-wide transition opacity-90 hover:opacity-100" style="background: var(--blue);">Save</button>
                        </div>
                    </form>
                </div>

                <!-- Add New Item Form Container -->
                <div class="bg-white p-4 rounded border border-gray-200 shadow-sm mt-5">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 text-base">Add New Item</h3>
                    
                    <form action="{{ route('inventory.store') }}" method="POST" class="space-y-2 text-xs font-semibold text-gray-700">
                        @csrf
                        <div>
                            <label class="block mb-0.5">SKU</label>
                            <input type="text" name="sku" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                        </div>
                        
                        <div>
                            <label class="block mb-0.5">Product Name</label>
                            <input type="text" name="productName" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                        </div>
                        
                        <div>
                            <label class="block mb-0.5">Description</label>
                            <textarea name="description" rows="3" class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)] resize-none"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-0.5">Category ID</label>
                                <input type="text" name="categoryId" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                            </div>
                            <div>
                                <label class="block mb-0.5">Quantity</label>
                                <input type="number" name="qty" value="0" required class="w-full p-2 border border-gray-300 rounded font-normal outline-none focus:border-[var(--sidebar)]">
                            </div>
                        </div>
                        
                        <div class="pt-2">
                            <button type="submit" class="w-full py-2 text-white font-bold rounded shadow-sm tracking-wide transition opacity-90 hover:opacity-100" style="background: var(--blue);">
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactions Grid Table Column Container (Right Side) -->
            <div class="lg:col-span-2 bg-white rounded border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-xs">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 font-bold">
                                <th class="p-3">Receipt ID</th>
                                <th class="p-3">PO ID</th>
                                <th class="p-3">PO Number</th>
                                <th class="p-3">Supplier Name</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Receipt Date</th>
                                <th class="p-3">Received By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600 font-medium">
                            @forelse($receipts as $receipt)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 font-bold text-gray-900">RC-{{ str_pad($receipt->receiptId, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="p-3">{{ $receipt->poId }}</td>
                                    <td class="p-3">#{{ $receipt->poNumber }}</td>
                                    <td class="p-3 font-bold text-gray-900">{{ $receipt->supplierName }}</td>
                                    <td class="p-3">
                                        @if($receipt->status == 'Delivered')
                                            <span class="px-2 py-0.5 rounded font-bold border" style="background:#e8f5e9; color:var(--green); border-color:#c8e6c9;">Delivered</span>
                                        @elseif($receipt->status == 'In Transit')
                                            <span class="px-2 py-0.5 rounded font-bold border" style="background:#e3f2fd; color:#1e88e5; border-color:#bbdefb;">In Transit</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded font-bold border" style="background:#fffde7; color:#fbc02d; border-color:#fff9c4;">Pending</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-gray-400">{{ date('Y-m-d H:i', strtotime($receipt->receiptDate)) }}</td>
                                    <td class="p-3">UID: {{ $receipt->receivedBy }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-gray-400 italic bg-white">No stocks added yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>