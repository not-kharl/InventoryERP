<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Transactions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar:#1e293b; --accent:#6366f1; --green:#10b981; --yellow:#f59e0b; --red:#ef4444; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter',sans-serif; }
        body { display:grid; grid-template-columns:240px 1fr; height:100vh; background:#f8fafc; overflow:hidden; }
        .sidebar { background:var(--sidebar); display:flex; flex-direction:column; padding:0; height:100vh; }
        .sidebar-logo { display:flex; align-items:center; gap:12px; padding:24px 20px 20px; border-bottom:1px solid rgba(255,255,255,0.08); }
        .logo-icon { width:36px; height:36px; background:#6366f1; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .logo-icon svg { width:18px; height:18px; stroke:white; fill:none; }
        .logo-text { font-size:15px; font-weight:700; color:white; letter-spacing:-0.3px; }
        .logo-sub { font-size:10px; color:rgba(255,255,255,0.4); font-weight:400; margin-top:1px; }
        .nav-wrap { padding:16px 12px; flex:1; }
        .nav-section { font-size:9.5px; font-weight:600; color:rgba(255,255,255,0.3); letter-spacing:0.08em; text-transform:uppercase; padding:0 8px; margin:0 0 8px; }
        .nav-link { display:flex; align-items:center; gap:10px; text-decoration:none; color:rgba(255,255,255,0.55); padding:9px 12px; margin:1px 0; border-radius:7px; font-size:13px; font-weight:500; transition:all 0.15s; }
        .nav-link svg { width:15px; height:15px; stroke:currentColor; fill:none; flex-shrink:0; }
        .nav-link:hover { background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.9); }
        .nav-link.active { background:rgba(99,102,241,0.2); color:white; font-weight:600; border-left:3px solid #6366f1; padding-left:9px; }
        .nav-dot { display:none; }
        .sidebar-footer { padding:14px 20px; border-top:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; gap:10px; }
        .sidebar-avatar { width:32px; height:32px; background:#6366f1; border-radius:8px; display:flex; align-items:center; justify-content:center; color:white; font-size:12px; font-weight:700; flex-shrink:0; }
        .sidebar-user-name { font-size:12.5px; font-weight:600; color:white; }
        .sidebar-user-role { font-size:10px; color:rgba(255,255,255,0.4); margin-top:1px; }
        .sidebar-chevron { margin-left:auto; opacity:0.3; }
        .sidebar-chevron svg { width:14px; height:14px; stroke:white; fill:none; }
        .main { display:flex; flex-direction:column; height:100vh; overflow:hidden; }
        .topbar { background:white; padding:0 28px; height:64px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #e2e8f0; flex-shrink:0; }
        .topbar-left { display:flex; flex-direction:column; }
        .page-title { font-size:17px; font-weight:700; color:#0f172a; letter-spacing:-0.3px; }
        .page-breadcrumb { font-size:11px; color:#94a3b8; display:flex; align-items:center; gap:4px; margin-top:1px; }
        .page-breadcrumb svg { width:10px; height:10px; stroke:#cbd5e1; fill:none; }
        .topbar-right { display:flex; align-items:center; gap:10px; }
        .search-wrap { position:relative; }
        .search-wrap svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); width:13px; height:13px; stroke:#94a3b8; fill:none; }
        .search { padding:7px 14px 7px 32px; border:1px solid #e2e8f0; border-radius:8px; background:#f8fafc; outline:none; font-size:12.5px; color:#334155; width:210px; transition:all 0.2s; }
        .search:focus { border-color:#6366f1; background:white; box-shadow:0 0 0 3px rgba(99,102,241,0.08); }
        .icon-btn { width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:white; display:flex; align-items:center; justify-content:center; cursor:pointer; position:relative; }
        .icon-btn svg { width:15px; height:15px; stroke:#64748b; fill:none; }
        .notif-dot { position:absolute; top:6px; right:6px; width:6px; height:6px; background:#ef4444; border-radius:50%; border:1.5px solid white; }
        .avatar-btn { width:34px; height:34px; background:linear-gradient(135deg,#6366f1,#818cf8); border-radius:8px; display:flex; align-items:center; justify-content:center; color:white; font-size:12px; font-weight:700; cursor:pointer; box-shadow:0 2px 8px rgba(99,102,241,0.3); }
        .divider { width:1px; height:20px; background:#e2e8f0; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        .content { flex:1; overflow-y:auto; padding:24px 28px; animation:fadeIn 0.25s ease; }
        .content::-webkit-scrollbar { width:4px; }
        .content::-webkit-scrollbar-thumb { background:#e2e8f0; border-radius:4px; }
        .layout { display:grid; grid-template-columns:300px 1fr; gap:20px; align-items:start; }
        .card { background:white; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden; margin-bottom:16px; }
        .card:last-child { margin-bottom:0; }
        .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; background:#fafbff; }
        .card-title { font-size:13.5px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
        .card-title-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
        .card-badge { font-size:10.5px; font-weight:600; padding:3px 9px; border-radius:20px; color:#64748b; background:#f1f5f9; }
        .form-body { padding:20px; }
        .form-group { margin-bottom:14px; }
        .form-label { display:block; font-size:11.5px; font-weight:600; color:#374151; margin-bottom:5px; }
        .form-input, .form-select { width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px; color:#1e293b; outline:none; background:#f8fafc; transition:all 0.2s; }
        .form-input:focus, .form-select:focus { border-color:#6366f1; background:white; box-shadow:0 0 0 3px rgba(99,102,241,0.08); }
        .form-input::placeholder { color:#94a3b8; }
        .form-textarea { width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px; color:#1e293b; outline:none; background:#f8fafc; resize:none; font-family:inherit; transition:all 0.2s; }
        .form-textarea:focus { border-color:#6366f1; background:white; box-shadow:0 0 0 3px rgba(99,102,241,0.08); }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .btn-submit { width:100%; padding:10px; background:linear-gradient(135deg,#6366f1,#4f46e5); color:white; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; margin-top:6px; box-shadow:0 4px 14px rgba(99,102,241,0.35); transition:all 0.2s; }
        .btn-submit:hover { box-shadow:0 6px 20px rgba(99,102,241,0.45); transform:translateY(-1px); }
        table { width:100%; border-collapse:collapse; }
        thead tr { background:linear-gradient(to right,#f1f5f9,#f8fafc); }
        th { padding:11px 16px; font-size:10px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.08em; text-align:left; border-bottom:2px solid #e2e8f0; white-space:nowrap; }
        td { padding:12px 16px; font-size:12.5px; color:#475569; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
        tbody tr:nth-child(even) td { background:#f8fafc; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr { transition:background 0.12s; }
        tbody tr:hover td { background:#eef2ff !important; color:#1e293b; }
        td:first-child, th:first-child { padding-left:20px; }
        td:last-child, th:last-child { padding-right:20px; }
        .receipt-id { font-weight:700; font-family:'Courier New',monospace; font-size:11.5px; background:#eef2ff; color:#4338ca; padding:2px 8px; border-radius:5px; border:1px solid #e0e7ff; }
        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:10.5px; font-weight:600; }
        .badge::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; flex-shrink:0; }
        .badge-green { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
        .badge-blue { background:#dbeafe; color:#1e40af; border:1px solid #bfdbfe; }
        .badge-yellow { background:#fef3c7; color:#92400e; border:1px solid #fde68a; }
        .alert-error { background:#fee2e2; border:1px solid #fecaca; color:#991b1b; font-size:12px; padding:10px 14px; border-radius:10px; margin-bottom:16px; }
        .alert-success { background:#d1fae5; border:1px solid #a7f3d0; color:#065f46; font-size:12px; padding:10px 14px; border-radius:10px; margin-bottom:16px; }
        .empty-state { padding:48px 20px; text-align:center; color:#94a3b8; font-size:13px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z"/></svg>
            </div>
            <div>
                <div class="logo-text">InventoryERP</div>
                <div class="logo-sub">Management System</div>
            </div>
        </div>
        <div class="nav-wrap">
            <div class="nav-section">Main Menu</div>
            <a href="{{ url('/') }}" class="nav-link">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Inventory <span class="nav-dot"></span>
            </a>
            <a href="{{ route('receipts.index') }}" class="nav-link active">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Stocks <span class="nav-dot"></span>
            </a>
            <a href="{{ route('reports.index') }}" class="nav-link">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Reports <span class="nav-dot"></span>
            </a>
            <a href="{{ url('/warehouse') }}" class="nav-link">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M4 21V9l8-6 8 6v12M9 21v-6h6v6"/></svg>
                Warehouse <span class="nav-dot"></span>
            </a>
        </div>
        <div class="sidebar-footer">
            <div class="sidebar-avatar">A</div>
            <div>
                <div class="sidebar-user-name">Admin</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
            <div class="sidebar-chevron"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></div>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <div class="page-title">Stock Transactions</div>
                <div class="page-breadcrumb">
                    Dashboard <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg> Stocks
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" placeholder="Search transactions..." class="search">
                </div>
                <div class="divider"></div>
                <div class="avatar-btn">A</div>
            </div>
        </div>

        <div class="content">
            @if ($errors->any())
                <div class="alert-error"><ul style="list-style:disc;padding-left:16px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif
            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <div class="layout">
                <div>
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title"><span class="card-title-dot" style="background:#6366f1;"></span>New Stock Transaction</span>
                        </div>
                        <div class="form-body">
                            <form action="{{ route('receipts.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">PO ID</label>
                                    <input type="number" name="poId" required class="form-input" placeholder="Purchase Order ID">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">PO Number</label>
                                    <input type="text" name="poNumber" required class="form-input" placeholder="e.g. PO-2024-001">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Supplier Name</label>
                                    <input type="text" name="supplierName" required class="form-input" placeholder="Supplier name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Received By (User ID)</label>
                                    <input type="number" name="receivedBy" required class="form-input" placeholder="User ID">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select name="status" required class="form-select">
                                        <option value="Pending">Pending</option>
                                        <option value="In Transit">In Transit</option>
                                        <option value="Delivered">Delivered</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn-submit">Save Transaction</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <span class="card-title"><span class="card-title-dot" style="background:#10b981;"></span>Add New Item</span>
                        </div>
                        <div class="form-body">
                            <form action="{{ route('inventory.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">SKU</label>
                                    <input type="text" name="sku" required class="form-input" placeholder="e.g. SKU-001">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" name="productName" required class="form-input" placeholder="Product name">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="2" class="form-textarea" placeholder="Optional description"></textarea>
                                </div>
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="form-label">Category ID</label>
                                        <input type="text" name="categoryId" required class="form-input" placeholder="Category">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Quantity</label>
                                        <input type="number" name="qty" value="0" required class="form-input">
                                    </div>
                                </div>
                                <button type="submit" class="btn-submit">Save Product</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title"><span class="card-title-dot" style="background:#f59e0b;"></span>Transactions</span>
                        <span class="card-badge">{{ count($receipts) }} records</span>
                    </div>
                    <div style="overflow-x:auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Receipt ID</th>
                                    <th>PO Number</th>
                                    <th>Supplier</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Received By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($receipts as $receipt)
                                    <tr>
                                        <td><span class="receipt-id">RC-{{ str_pad($receipt->receiptId, 4, '0', STR_PAD_LEFT) }}</span></td>
                                        <td style="font-weight:600; color:#0f172a;">#{{ $receipt->poNumber }}</td>
                                        <td>{{ $receipt->supplierName }}</td>
                                        <td>
                                            @if($receipt->status == 'Delivered')
                                                <span class="badge badge-green">Delivered</span>
                                            @elseif($receipt->status == 'In Transit')
                                                <span class="badge badge-blue">In Transit</span>
                                            @else
                                                <span class="badge badge-yellow">Pending</span>
                                            @endif
                                        </td>
                                        <td style="color:#94a3b8; font-size:12px;">{{ date('M d, Y', strtotime($receipt->receiptDate)) }}</td>
                                        <td style="color:#64748b;">UID: {{ $receipt->receivedBy }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6"><div class="empty-state">No transactions recorded yet.</div></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
