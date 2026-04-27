<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shipping Label - @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Inter', sans-serif; background:#f1f5f9; color:#0f172a; }
        .sidebar {
            position: fixed; top:0; left:0; height:100%; width:280px;
            background: linear-gradient(145deg, #f0f9ff 0%, #bae6fd 100%);
            color: #0c4a6e; transition: all 0.3s; z-index:1050; overflow-y:auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.05);
            border-right:1px solid rgba(255,255,255,0.5);
        }
        .sidebar-logo { text-align:center; padding:28px 20px 20px; border-bottom:1px solid rgba(12,74,110,0.1); margin-bottom:20px; }
        .sidebar-logo img { max-width:140px; filter:drop-shadow(2px 2px 4px rgba(0,0,0,0.05)); transition:transform 0.2s; }
        .sidebar-logo img:hover { transform:scale(1.02); }
        .sidebar .nav { padding:0 12px; }
        .sidebar .nav-link {
            color:#0c4a6e; padding:12px 16px; margin:6px 0; border-radius:14px;
            transition:0.25s; font-weight:500; display:flex; align-items:center; gap:12px;
        }
        .sidebar .nav-link i { width:24px; font-size:1.2rem; text-align:center; color:#0284c7; }
        .sidebar .nav-link:hover { background:white; color:#0369a1; transform:translateX(4px); box-shadow:0 4px 10px rgba(0,0,0,0.05); }
        .sidebar .nav-link.active { background:white; color:#0369a1; box-shadow:0 6px 14px rgba(0,0,0,0.08); font-weight:600; }
        .sidebar .nav-link.active i { color:#0369a1; }
        .sidebar::-webkit-scrollbar { width:5px; }
        .sidebar::-webkit-scrollbar-track { background:#e0f2fe; }
        .sidebar::-webkit-scrollbar-thumb { background:#7dd3fc; border-radius:10px; }
        .content { margin-left:280px; padding:24px 32px; min-height:100vh; transition:margin-left 0.3s; }
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1060;
            background: #0284c7;
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            font-size: 1.4rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            transition: 0.2s;
            cursor: pointer;
        }
        .sidebar-toggle:hover { background:#0369a1; transform:scale(1.02); }
        @media (max-width:768px) {
            .sidebar { margin-left:-280px; }
            .sidebar.show { margin-left:0; }
            .content { margin-left:0; padding:20px 16px; }
            .sidebar-toggle { display:flex; align-items:center; justify-content:center; }
        }
        .card-modern { border:none; border-radius:24px; background:white; box-shadow:0 8px 20px -6px rgba(0,0,0,0.05), 0 2px 4px -2px rgba(0,0,0,0.02); transition:0.3s; }
        .card-modern:hover { transform:translateY(-2px); box-shadow:0 20px 25px -12px rgba(0,0,0,0.1); }
        .btn-modern { border-radius:40px; padding:8px 24px; font-weight:500; transition:0.2s; }
        .btn-modern:hover { transform:translateY(-2px); }
        footer { text-align:center; margin-top:40px; padding-top:20px; border-top:1px solid #cbd5e1; color:#475569; font-size:0.85rem; }
        .sidebar-stats .stat-card {
            background: rgba(255,255,255,0.2);
            transition: all 0.2s;
            border-radius: 12px;
            padding: 8px 12px;
        }
        .sidebar-stats .stat-card:hover {
            background: rgba(255,255,255,0.35);
            transform: translateX(3px);
        }
        .sidebar-stats .stat-label {
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0c4a6e;
            opacity: 0.8;
        }
        .sidebar-stats .stat-number {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.2;
            color: #0369a1;
        }
        @media (max-width: 768px) {
            .content { padding: 16px !important; }
            .card-modern { border-radius: 16px !important; }
            .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .table { min-width: 600px; }
            h1.display-5 { font-size: 1.8rem; }
            .btn-group { flex-wrap: wrap; gap: 4px; }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" id="sidebarToggleBtn"><i class="fas fa-bars"></i></button>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan">
        </div>

        <!-- Quick Stats -->
        <div class="sidebar-stats px-3 mb-4">
            <div class="stat-card mb-2">
                <div class="stat-label">Pengiriman Hari Ini</div>
                <div class="stat-number">{{ $sidebarStats['today_shipments'] ?? 0 }}</div>
            </div>
            <div class="stat-card mb-2">
                <div class="stat-label">Resi Belum Diisi</div>
                <div class="stat-number">{{ $sidebarStats['pending_resi'] ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Paket Terkirim</div>
                <div class="stat-number">{{ $sidebarStats['total_packages'] ?? 0 }}</div>
            </div>
        </div>

        <!-- Tombol Tambah Pengiriman di Sidebar -->
        <div class="px-3 mb-3">
            <a href="{{ route('shipments.create') }}" class="btn btn-success w-100 rounded-pill">
                <i class="fas fa-plus-circle me-2"></i> Tambah Pengiriman
            </a>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('shipments.*') ? 'active' : '' }}" href="{{ route('shipments.index') }}"><i class="fas fa-list-alt"></i> Daftar Pengiriman</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}"><i class="fas fa-folder-open"></i> Proyek</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('reports.cost') ? 'active' : '' }}" href="{{ route('reports.cost') }}"><i class="fas fa-chart-pie"></i> Laporan Biaya</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('laporan') ? 'active' : '' }}" href="{{ route('laporan') }}"><i class="fas fa-chart-line"></i> Data Pengiriman per Bulan</a></li>
            <li class="nav-item mt-4"><hr style="border-color:rgba(12,74,110,0.1);"></li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link" style="background:none; border:none; width:100%; text-align:left;"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
        <footer>&copy; {{ date('Y') }} Sistem Label Pengiriman — <i class="fas fa-ship"></i> ShipLabel</footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const sidebar = document.getElementById('sidebar');
            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('show');
                });
                document.addEventListener('click', function(event) {
                    if(window.innerWidth <= 768 && sidebar.classList.contains('show') && !sidebar.contains(event.target) && event.target !== toggleBtn && !toggleBtn.contains(event.target)) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>