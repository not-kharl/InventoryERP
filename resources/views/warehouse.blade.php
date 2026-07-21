<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Warehouse</title>
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
        .page-breadcrumb { font-size:11px; color:#94a3b8; font-weight:400; display:flex; align-items:center; gap:4px; margin-top:1px; }
        .page-breadcrumb svg { width:10px; height:10px; stroke:#cbd5e1; fill:none; }
        .topbar-right { display:flex; align-items:center; gap:10px; }
        .search-wrap { position:relative; }
        .search-wrap svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); width:13px; height:13px; stroke:#94a3b8; fill:none; }
        .search { padding:7px 14px 7px 32px; border:1px solid #e2e8f0; border-radius:8px; background:#f8fafc; outline:none; font-size:12.5px; color:#334155; width:210px; transition:all 0.2s; }
        .search:focus { border-color:#6366f1; background:white; box-shadow:0 0 0 3px rgba(99,102,241,0.08); }
        .icon-btn { width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:white; display:flex; align-items:center; justify-content:center; cursor:pointer; position:relative; transition:all 0.15s; }
        .icon-btn:hover { background:#f8fafc; }
        .icon-btn svg { width:15px; height:15px; stroke:#64748b; fill:none; }
        .notif-dot { position:absolute; top:6px; right:6px; width:6px; height:6px; background:#ef4444; border-radius:50%; border:1.5px solid white; }
        .avatar-btn { width:34px; height:34px; background:linear-gradient(135deg,#6366f1,#818cf8); border-radius:8px; display:flex; align-items:center; justify-content:center; color:white; font-size:12px; font-weight:700; cursor:pointer; box-shadow:0 2px 8px rgba(99,102,241,0.3); }
        .divider { width:1px; height:20px; background:#e2e8f0; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
        .content { flex:1; overflow-y:auto; padding:24px 28px; animation:fadeIn 0.25s ease; }
        .content::-webkit-scrollbar { width:4px; }
        .content::-webkit-scrollbar-thumb { background:#e2e8f0; border-radius:4px; }
        .layout { display:grid; grid-template-columns:300px 1fr; gap:20px; align-items:start; }
        .card { background:white; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 1px 4px rgba(0,0,0,0.04); overflow:hidden; }
        .card-header { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; background:#fafbff; }
        .card-title { font-size:13.5px; font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px; }
        .card-title-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
        .card-badge { font-size:10.5px; font-weight:600; padding:3px 9px; border-radius:20px; color:#64748b; background:#f1f5f9; }
        .form-body { padding:20px; }
        .form-group { margin-bottom:14px; }
        .form-label { display:block; font-size:11.5px; font-weight:600; color:#374151; margin-bottom:5px; letter-spacing:0.01em; }
        .form-input, .form-select { width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px; color:#1e293b; outline:none; background:#f8fafc; transition:all 0.2s; }
        .form-input:focus, .form-select:focus { border-color:#6366f1; background:white; box-shadow:0 0 0 3px rgba(99,102,241,0.08); }
        .form-input::placeholder { color:#94a3b8; }
        .btn-submit { width:100%; padding:10px; background:linear-gradient(135deg,#6366f1,#4f46e5); color:white; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; margin-top:6px; box-shadow:0 4px 14px rgba(99,102,241,0.35); transition:all 0.2s; letter-spacing:0.01em; }
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
        .location-id { font-weight:700; font-family:'Courier New',monospace; font-size:11.5px; background:#eef2ff; color:#4338ca; padding:2px 8px; border-radius:5px; border:1px solid #e0e7ff; }
        .zone-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:10.5px; font-weight:600; background:#ede9fe; color:#5b21b6; border:1px solid #ddd6fe; }
        .stat-card { background:#eef2ff; border:1px solid #c7d2fe; border-radius:14px; padding:20px 22px; display:flex; align-items:center; gap:16px; margin-top:16px; transition:transform 0.2s; }
        .stat-card:hover { transform:translateY(-2px); }
        .stat-icon-wrap { width:46px; height:46px; background:#e0e7ff; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-icon-wrap svg { width:22px; height:22px; stroke:#4f46e5; fill:none; }
        .stat-label { font-size:11px; font-weight:600; color:#6366f1; text-transform:uppercase; letter-spacing:0.06em; }
        .stat-value { font-size:30px; font-weight:800; color:#312e81; line-height:1; margin-top:4px; letter-spacing:-1px; }
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
            <a href="{{ route('receipts.index') }}" class="nav-link">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Stocks <span class="nav-dot"></span>
            </a>
            <a href="{{ route('reports.index') }}" class="nav-link">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Reports <span class="nav-dot"></span>
            </a>
            <a href="{{ route('warehouse') }}" class="nav-link active">
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
                <div class="page-title">Warehouse</div>
                <div class="page-breadcrumb">
                    Dashboard <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg> Warehouse
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" placeholder="Search warehouses..." class="search">
                </div>
                <div class="divider"></div>
                <div class="avatar-btn">A</div>
            </div>
        </div>

        <div class="content">
            <div class="layout">
                <div>
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title"><span class="card-title-dot" style="background:#6366f1;"></span>Add New Warehouse</span>
                        </div>
                        <div class="form-body">
                            <form action="{{ route('warehouse.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Warehouse Code</label>
                                    <input type="text" name="warehouseCode" required class="form-input" placeholder="e.g. WH-001">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Zone</label>
                                    <select name="zone" required class="form-select">
                                        <option value="" disabled selected>Select a zone</option>
                                        <option value="1">1 — North Luzon</option>
                                        <option value="2">2 — Metro Manila</option>
                                        <option value="3">3 — Davao</option>
                                        <option value="4">4 — Central Visayas</option>
                                        <option value="5">5 — Zamboanga</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Capacity Quantity</label>
                                    <input type="number" step="0.01" name="capacityQty" required class="form-input" placeholder="0">
                                </div>
                                <button type="submit" class="btn-submit">Save Warehouse</button>
                            </form>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon-wrap">
                            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M4 21V9l8-6 8 6v12M9 21v-6h6v6"/></svg>
                        </div>
                        <div>
                            <div class="stat-label">Total Warehouses</div>
                            <div class="stat-value">{{ $warehouses->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title"><span class="card-title-dot" style="background:#8b5cf6;"></span>Warehouse Locations</span>
                        <span class="card-badge">{{ $warehouses->count() }} total</span>
                    </div>
                    <div style="overflow-x:auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Location ID</th>
                                    <th>Warehouse Code</th>
                                    <th>Zone</th>
                                    <th>Capacity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $zoneNames = [1=>'North Luzon',2=>'Metro Manila',3=>'Davao',4=>'Central Visayas',5=>'Zamboanga']; @endphp
                                @forelse($warehouses as $warehouse)
                                    <tr>
                                        <td><span class="location-id">{{ $warehouse->locationId }}</span></td>
                                        <td style="font-weight:600; color:#0f172a;">{{ $warehouse->warehouseCode }}</td>
                                        <td><span class="zone-badge">{{ $zoneNames[$warehouse->zone] ?? $warehouse->zone }}</span></td>
                                        <td style="font-weight:700; color:#0f172a;">{{ number_format($warehouse->capacityQty) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4"><div class="empty-state">No warehouses added yet.</div></td></tr>
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
