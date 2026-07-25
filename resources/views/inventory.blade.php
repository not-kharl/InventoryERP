<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Overview</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar:#1e293b; --accent:#6366f1; --accent2:#818cf8; --green:#10b981; --yellow:#f59e0b; --red:#ef4444; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter',sans-serif; }
        body { display:grid; grid-template-columns:240px 1fr; height:100vh; background:#f8fafc; overflow:hidden; }

        /* SIDEBAR */
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

        /* MAIN */
        .main { display:flex; flex-direction:column; height:100vh; overflow:hidden; }
        .topbar { background:white; padding:0 28px; height:64px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #e2e8f0; flex-shrink:0; }
        .topbar-left { display:flex; flex-direction:column; }
        .page-title { font-size:17px; font-weight:700; color:#0f172a; letter-spacing:-0.3px; }
        .page-breadcrumb { font-size:11px; color:#94a3b8; font-weight:400; display:flex; align-items:center; gap:4px; margin-top:1px; }
        .page-breadcrumb svg { width:10px; height:10px; stroke:#cbd5e1; fill:none; }
        .topbar-right { display:flex; align-items:center; gap:10px; }
        .search-wrap { position:relative; }
        .search-wrap svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); width:13px; height:13px; stroke:#94a3b8; fill:none; }
        .search { padding:7px 14px 7px 32px; border:1px solid #e2e8f0; border-radius:8px; background:#f8fafc; outline:none; font-size:12.5px; color:#334155; width:210px; transition:all 0.2s; }
        .search:focus { border-color:#6366f1; background:white; box-shadow:0 0 0 3px rgba(99,102,241,0.08); width:240px; }
        .icon-btn { width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:white; display:flex; align-items:center; justify-content:center; cursor:pointer; position:relative; transition:all 0.15s; }
        .icon-btn:hover { background:#f8fafc; border-color:#cbd5e1; }
        .icon-btn svg { width:15px; height:15px; stroke:#64748b; fill:none; }
        .notif-dot { position:absolute; top:6px; right:6px; width:6px; height:6px; background:#ef4444; border-radius:50%; border:1.5px solid white; }
        .avatar-btn { width:34px; height:34px; background:linear-gradient(135deg,#6366f1,#818cf8); border-radius:8px; display:flex; align-items:center; justify-content:center; color:white; font-size:12px; font-weight:700; cursor:pointer; box-shadow:0 2px 8px rgba(99,102,241,0.3); }
        .divider { width:1px; height:20px; background:#e2e8f0; }

        /* REORDER BUTTON */
        .btn-reorder { display:inline-flex; align-items:center; gap:7px; background:#6366f1; color:white; border:none; padding:8px 16px; border-radius:8px; font-size:12.5px; font-weight:600; cursor:pointer; box-shadow:0 2px 8px rgba(99,102,241,0.3); transition:all 0.15s; white-space:nowrap; }
        .btn-reorder:hover { background:#4f46e5; transform:translateY(-1px); box-shadow:0 4px 10px rgba(99,102,241,0.35); }
        .btn-reorder svg { width:14px; height:14px; stroke:white; fill:none; flex-shrink:0; }

        /* PAGE TRANSITION */
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        .content { flex:1; overflow-y:auto; padding:24px 28px; animation:fadeIn 0.25s ease; }
        .content::-webkit-scrollbar { width:4px; }
        .content::-webkit-scrollbar-track { background:transparent; }
        .content::-webkit-scrollbar-thumb { background:#e2e8f0; border-radius:4px; }

        /* STAT CARDS */
        .stat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:20px; }
        .stat-card { border-radius:14px; padding:20px 22px; display:flex; align-items:center; gap:16px; transition:transform 0.2s, box-shadow 0.2s; cursor:default; border:1px solid transparent; }
        .stat-card:hover { transform:translateY(-2px); }
        .stat-card.blue { background:#eef2ff; border-color:#c7d2fe; }
        .stat-card.yellow { background:#fffbeb; border-color:#fde68a; }
        .stat-card.red { background:#fff1f2; border-color:#fecdd3; }
        .stat-icon-wrap { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-card.blue .stat-icon-wrap { background:#e0e7ff; }
        .stat-card.yellow .stat-icon-wrap { background:#fef3c7; }
        .stat-card.red .stat-icon-wrap { background:#ffe4e6; }
        .stat-card.blue .stat-icon-wrap svg { stroke:#4f46e5; }
        .stat-card.yellow .stat-icon-wrap svg { stroke:#d97706; }
        .stat-card.red .stat-icon-wrap svg { stroke:#e11d48; }
        .stat-icon-wrap svg { width:22px; height:22px; fill:none; }
        .stat-label { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.06em; }
        .stat-card.blue .stat-label { color:#6366f1; }
        .stat-card.yellow .stat-label { color:#d97706; }
        .stat-card.red .stat-label { color:#e11d48; }
        .stat-value { font-size:30px; font-weight:800; line-height:1; margin-top:4px; letter-spacing:-1px; }
        .stat-card.blue .stat-value { color:#312e81; }
        .stat-card.yellow .stat-value { color:#78350f; }
        .stat-card.red .stat-value { color:#881337; }
        .stat-trend { font-size:10.5px; margin-top:4px; font-weight:500; }
        .stat-card.blue .stat-trend { color:#818cf8; }
        .stat-card.yellow .stat-trend { color:#f59e0b; }
        .stat-card.red .stat-trend { color:#fb7185; }

        /* CARDS */
        .bottom-grid { display:grid; grid-template-columns:1fr 300px; gap:16px; }
        .card { background:white; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden; }
        .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; background:#fafbff; }
        .card-title { font-size:13.5px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
        .card-title-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
        .card-badge { font-size:10.5px; font-weight:600; padding:3px 9px; border-radius:20px; }
        .card-badge.gray { color:#64748b; background:#f1f5f9; }
        .card-header-actions { display:flex; align-items:center; gap:10px; }

        /* TABLE */
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
        .sku { font-weight:700; color:#1e1b4b; font-family:'Courier New',monospace; font-size:11.5px; background:#eef2ff; color:#4338ca; padding:2px 8px; border-radius:5px; border:1px solid #e0e7ff; }
        .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:10.5px; font-weight:600; }
        .badge::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; flex-shrink:0; }
        .badge-green { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0; }
        .badge-red { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }

        /* ROW REORDER BUTTON */
        .btn-row-reorder { display:inline-flex; align-items:center; gap:4px; background:#eef2ff; color:#4338ca; border:1px solid #e0e7ff; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer; transition:all 0.15s; white-space:nowrap; }
        .btn-row-reorder:hover { background:#e0e7ff; border-color:#c7d2fe; }
        .btn-row-reorder svg { width:11px; height:11px; stroke:#4338ca; fill:none; flex-shrink:0; }

        /* ACTIVITY */
        .activity-item { display:flex; gap:12px; padding:11px 20px; border-bottom:1px solid #f8fafc; align-items:flex-start; }
        .activity-item:last-child { border-bottom:none; }
        .activity-line { display:flex; flex-direction:column; align-items:center; gap:0; }
        .activity-dot { width:9px; height:9px; border-radius:50%; flex-shrink:0; margin-top:3px; border:2px solid white; box-shadow:0 0 0 2px currentColor; }
        .activity-text { font-size:12px; font-weight:500; color:#334155; line-height:1.4; }
        .activity-time { font-size:10.5px; color:#94a3b8; margin-top:2px; font-weight:500; }
        .empty-state { padding:48px 20px; text-align:center; color:#94a3b8; font-size:13px; }
        .empty-state svg { width:36px; height:36px; stroke:#cbd5e1; fill:none; margin:0 auto 10px; display:block; }

        /* REORDER MODAL */
        .modal-overlay { position:fixed; inset:0; background:rgba(15,23,42,0.5); display:none; align-items:center; justify-content:center; z-index:100; padding:20px; }
        .modal-overlay.open { display:flex; }
        .modal-box { background:white; border-radius:14px; width:100%; max-width:560px; max-height:85vh; display:flex; flex-direction:column; box-shadow:0 20px 50px rgba(0,0,0,0.2); }
        .modal-header { padding:18px 22px; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
        .modal-title { font-size:15px; font-weight:700; color:#0f172a; }
        .modal-subtitle { font-size:11.5px; color:#94a3b8; margin-top:2px; font-weight:400; }
        .modal-close { width:28px; height:28px; border-radius:7px; border:none; background:transparent; display:flex; align-items:center; justify-content:center; cursor:pointer; }
        .modal-close:hover { background:#f1f5f9; }
        .modal-close svg { width:16px; height:16px; stroke:#64748b; fill:none; }
        .modal-body { padding:20px 22px; overflow-y:auto; flex:1; }
        .form-group { margin-bottom:16px; }
        .form-label { font-size:11.5px; font-weight:600; color:#475569; margin-bottom:6px; display:block; }
        .form-select, .form-input, .form-textarea { width:100%; padding:9px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:12.5px; font-family:'Inter',sans-serif; color:#334155; outline:none; transition:all 0.15s; }
        .form-select:focus, .form-input:focus, .form-textarea:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.08); }
        .form-textarea { resize:vertical; min-height:60px; }
        .form-row { display:flex; gap:12px; }
        .form-row .form-group { flex:1; }
        .modal-items-table { width:100%; border-collapse:collapse; font-size:12px; margin-top:6px; }
        .modal-items-table th { padding:7px 8px; font-size:10px; text-transform:uppercase; color:#94a3b8; text-align:left; border-bottom:1px solid #e2e8f0; }
        .modal-items-table td { padding:8px; border-bottom:1px solid #f1f5f9; }
        .modal-items-table input[type="number"] { width:70px; padding:5px 8px; border:1px solid #e2e8f0; border-radius:6px; font-size:12px; }
        .modal-items-table .rm-row { background:none; border:none; cursor:pointer; color:#ef4444; }
        .modal-items-table .rm-row svg { width:14px; height:14px; stroke:#ef4444; fill:none; }
        .add-item-row { display:flex; gap:8px; margin-top:10px; }
        .add-item-row select { flex:1; }
        .btn-add-item { padding:8px 14px; border-radius:8px; border:1px solid #e0e7ff; background:#eef2ff; color:#4338ca; font-size:12px; font-weight:600; cursor:pointer; white-space:nowrap; }
        .btn-add-item:hover { background:#e0e7ff; }
        .btn-add-item:disabled { opacity:0.5; cursor:not-allowed; }
        .modal-footer { padding:16px 22px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px; flex-shrink:0; }
        .btn-cancel { padding:9px 18px; border-radius:8px; border:1px solid #e2e8f0; background:white; color:#334155; font-size:12.5px; font-weight:600; cursor:pointer; }
        .btn-cancel:hover { background:#f8fafc; }
        .btn-submit { padding:9px 18px; border-radius:8px; border:none; background:#6366f1; color:white; font-size:12.5px; font-weight:600; cursor:pointer; }
        .btn-submit:hover { background:#4f46e5; }
        .btn-submit:disabled { opacity:0.6; cursor:not-allowed; }
        .modal-alert { font-size:11.5px; padding:8px 12px; border-radius:8px; margin-bottom:14px; display:none; }
        .modal-alert.error { background:#fee2e2; color:#991b1b; display:block; }
        .modal-alert.success { background:#d1fae5; color:#065f46; display:block; }
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
            <a href="{{ url('/') }}" class="nav-link active">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Inventory <span class="nav-dot"></span>
            </a>
            <a href="{{ route('receipts.index') }}" class="nav-link">
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
                <div class="page-title">Inventory Overview</div>
                <div class="page-breadcrumb">
                    Dashboard <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg> Inventory
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" placeholder="Search products..." class="search">
                </div>
                <div class="divider"></div>
                <button type="button" class="btn-reorder" id="topReorderBtn">
                    <svg viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 11-2.64-6.36"/><polyline points="21 3 21 9 15 9"/></svg>
                    Reorder Request
                </button>
                <div class="divider"></div>
                <div class="avatar-btn">A</div>
            </div>
        </div>

        <div class="content">
            <div class="stat-grid">
                <div class="stat-card blue">
                    <div class="stat-icon-wrap">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Total Products</div>
                        <div class="stat-value">{{ $totalProducts }}</div>
                        <div class="stat-trend">All registered items</div>
                    </div>
                </div>
                <div class="stat-card yellow">
                    <div class="stat-icon-wrap">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Pending Orders</div>
                        <div class="stat-value">{{ $pendingOrders }}</div>
                        <div class="stat-trend">Awaiting processing</div>
                    </div>
                </div>
                <div class="stat-card red">
                    <div class="stat-icon-wrap">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <div>
                        <div class="stat-label">Low Stock Alerts</div>
                        <div class="stat-value">{{ $lowStockCount }}</div>
                        <div class="stat-trend">Items below threshold</div>
                    </div>
                </div>
            </div>

            <div class="bottom-grid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <span class="card-title-dot" style="background:#6366f1;"></span>
                            Product List
                        </span>
                        <div class="card-header-actions">
                            <span class="card-badge gray">{{ $totalProducts }} items</span>
                        </div>
                    </div>
                    <div style="overflow-x:auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>QTY</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="productTableBody">
                                @forelse($items as $item)
                                    <tr>
                                        <td><span class="sku">{{ $item->sku }}</span></td>
                                        <td style="font-weight:600; color:#0f172a;">{{ $item->productName }}</td>
                                        <td>{{ $item->categoryId }}</td>
                                        <td style="font-weight:700; color:#0f172a;">{{ $item->qty }}</td>
                                        <td>
                                            @if($item->qty <= 10)
                                                <span class="badge badge-red">Low Stock</span>
                                            @else
                                                <span class="badge badge-green">In Stock</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->qty <= 10)
                                                <button type="button" class="btn-row-reorder js-reorder-item"
                                                    data-id="{{ $item->id }}"
                                                    data-sku="{{ $item->sku }}"
                                                    data-name="{{ $item->productName }}"
                                                    data-qty="{{ $item->qty }}">
                                                    <svg viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 11-2.64-6.36"/><polyline points="21 3 21 9 15 9"/></svg>
                                                    Reorder
                                                </button>
                                            @else
                                                <span style="color:#cbd5e1; font-size:11px;">&mdash;</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6">
                                        <div class="empty-state">
                                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/></svg>
                                            No products added yet.
                                        </div>
                                    </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <span class="card-title-dot" style="background:#10b981;"></span>
                            Recent Activity
                        </span>
                    </div>
                    @forelse($activities ?? [] as $activity)
                        <div class="activity-item">
                            <div class="activity-dot
                                @if(($activity->status ?? '') === 'Delivered') style="color:#10b981;"
                                @elseif(($activity->status ?? '') === 'Pending') style="color:#f59e0b;"
                                @else style="color:#6366f1;" @endif">
                            </div>
                            <div>
                                <div class="activity-text">{{ $activity->description ?? '' }}</div>
                                <div class="activity-time">{{ isset($activity->created_at) ? $activity->created_at->diffForHumans() : '' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            No recent activity recorded.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- REORDER REQUEST MODAL -->
    <div class="modal-overlay" id="reorderModal">
        <div class="modal-box">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Reorder request</div>
                    <div class="modal-subtitle">Sends a stock request order to procurement</div>
                </div>
                <button type="button" class="modal-close" id="modalCloseBtn">
                    <svg viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="reorderForm">
                @csrf
                <div class="modal-body">
                    <div class="modal-alert" id="reorderAlert"></div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Warehouse / branch</label>
                            <select class="form-select" name="warehouse_id">
                                <option value="1">Main warehouse</option>
                                <option value="2">North branch</option>
                                <option value="3">South branch</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Send to</label>
                            <select class="form-select" name="department">
                                <option value="procurement">Procurement dept.</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Items to reorder</label>
                        <table class="modal-items-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>On hand</th>
                                    <th>Qty to request</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="reorderItemsBody">
                                <!-- rows injected by JS -->
                            </tbody>
                        </table>

                        <div class="add-item-row">
                            <select class="form-select" id="addItemSelect">
                                <option value="">+ Add a low-stock item...</option>
                            </select>
                            <button type="button" class="btn-add-item" id="addItemBtn">Add</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea class="form-textarea" name="notes" placeholder="Optional notes for procurement..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="modalCancelBtn">Cancel</button>
                    <button type="submit" class="btn-submit" id="reorderSubmitBtn">Send request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let reorderItems = [];

        // Build the master list of low-stock items straight from the rendered table
        // (data-* attributes avoid any quote/apostrophe issues from product names).
        function getLowStockItemsFromTable() {
            return Array.from(document.querySelectorAll('.js-reorder-item')).map(btn => ({
                id: parseInt(btn.dataset.id, 10),
                sku: btn.dataset.sku,
                name: btn.dataset.name,
                qty: parseInt(btn.dataset.qty, 10)
            }));
        }

        function openReorderModal(preselectedItems) {
            reorderItems = (preselectedItems || []).map(it => ({
                ...it,
                requestQty: Math.max((it.qty || 0) * 3, 10)
            }));
            renderReorderItems();
            populateAddItemSelect();
            document.getElementById('reorderAlert').style.display = 'none';
            document.getElementById('reorderModal').classList.add('open');
        }

        function closeReorderModal() {
            document.getElementById('reorderModal').classList.remove('open');
        }

        function renderReorderItems() {
            const body = document.getElementById('reorderItemsBody');
            if (reorderItems.length === 0) {
                body.innerHTML = '<tr><td colspan="4" style="text-align:center; color:#94a3b8; padding:16px;">No items yet. Use the dropdown below to add a low-stock item.</td></tr>';
                return;
            }
            body.innerHTML = reorderItems.map((it, idx) => `
                <tr>
                    <td>
                        <div style="font-weight:600; color:#0f172a;"></div>
                        <div style="color:#94a3b8; font-size:11px;"></div>
                    </td>
                    <td></td>
                    <td><input type="number" min="1" value="${it.requestQty}" data-idx="${idx}" class="js-qty-input"></td>
                    <td><button type="button" class="rm-row js-remove-item" data-idx="${idx}"><svg viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg></button></td>
                </tr>
            `).join('');

            // Fill text content via textContent (not string interpolation) so item
            // names with quotes/HTML-special characters render safely.
            Array.from(body.querySelectorAll('tr')).forEach((row, idx) => {
                const it = reorderItems[idx];
                row.children[0].children[0].textContent = it.name;
                row.children[0].children[1].textContent = it.sku;
                row.children[1].textContent = it.qty;
            });
        }

        function populateAddItemSelect() {
            const select = document.getElementById('addItemSelect');
            const all = getLowStockItemsFromTable();
            const alreadyAdded = new Set(reorderItems.map(it => it.id));
            const available = all.filter(it => !alreadyAdded.has(it.id));

            select.innerHTML = '<option value="">+ Add a low-stock item...</option>' +
                available.map(it => `<option value="${it.id}">${it.name} (${it.sku}) — on hand: ${it.qty}</option>`).join('');

            document.getElementById('addItemBtn').disabled = available.length === 0;
        }

        // Event delegation: qty edits + row removal inside the items table
        document.getElementById('reorderItemsBody').addEventListener('input', function(e) {
            if (e.target.classList.contains('js-qty-input')) {
                const idx = parseInt(e.target.dataset.idx, 10);
                reorderItems[idx].requestQty = parseInt(e.target.value, 10) || 1;
            }
        });

        document.getElementById('reorderItemsBody').addEventListener('click', function(e) {
            const btn = e.target.closest('.js-remove-item');
            if (btn) {
                const idx = parseInt(btn.dataset.idx, 10);
                reorderItems.splice(idx, 1);
                renderReorderItems();
                populateAddItemSelect();
            }
        });

        document.getElementById('addItemBtn').addEventListener('click', function() {
            const select = document.getElementById('addItemSelect');
            const id = parseInt(select.value, 10);
            if (!id) return;
            const item = getLowStockItemsFromTable().find(it => it.id === id);
            if (item) {
                reorderItems.push({ ...item, requestQty: Math.max(item.qty * 3, 10) });
                renderReorderItems();
                populateAddItemSelect();
            }
        });

        // Top toolbar button: auto-populate with every low-stock item currently in the table
        document.getElementById('topReorderBtn').addEventListener('click', function() {
            openReorderModal(getLowStockItemsFromTable());
        });

        // Per-row reorder buttons (event delegation, safe against special characters in names)
        document.getElementById('productTableBody').addEventListener('click', function(e) {
            const btn = e.target.closest('.js-reorder-item');
            if (!btn) return;
            openReorderModal([{
                id: parseInt(btn.dataset.id, 10),
                sku: btn.dataset.sku,
                name: btn.dataset.name,
                qty: parseInt(btn.dataset.qty, 10)
            }]);
        });

        document.getElementById('modalCloseBtn').addEventListener('click', closeReorderModal);
        document.getElementById('modalCancelBtn').addEventListener('click', closeReorderModal);

        document.getElementById('reorderModal').addEventListener('click', function(e) {
            if (e.target === this) closeReorderModal();
        });

        document.getElementById('reorderForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const alertBox = document.getElementById('reorderAlert');
            const submitBtn = document.getElementById('reorderSubmitBtn');

            if (reorderItems.length === 0) {
                alertBox.className = 'modal-alert error';
                alertBox.textContent = 'Add at least one item before sending the request.';
                return;
            }

            const payload = {
                warehouse_id: this.warehouse_id.value,
                department: this.department.value,
                notes: this.notes.value,
                items: reorderItems.map(it => ({ product_id: it.id, sku: it.sku, qty: it.requestQty }))
            };

            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';

            try {
                const res = await fetch("{{ route('reorder.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                if (!res.ok) throw new Error('Request failed');

                alertBox.className = 'modal-alert success';
                alertBox.textContent = 'Reorder request sent to procurement.';
                setTimeout(() => { closeReorderModal(); location.reload(); }, 900);
            } catch (err) {
                alertBox.className = 'modal-alert error';
                alertBox.textContent = 'Could not send the request. Please try again.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send request';
            }
        });
    </script>
</body>
</html>
