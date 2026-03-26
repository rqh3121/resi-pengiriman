<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Label - @yield('title', 'Label Pengiriman')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --light-bg: #f8f9fa;
            --border-radius: 12px;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(90deg, #1e3c72 0%, #2a5298 100%) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 30px -12px rgba(0,0,0,0.15);
        }
        .card-header {
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            font-weight: 600;
            border-bottom: none;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.2s;
        }
        .btn-sm {
            padding: 5px 10px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0b5ed7, #0a58ca);
            transform: translateY(-1px);
        }
        .btn-success {
            background: linear-gradient(135deg, #198754, #157347);
            border: none;
        }
        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #ffca2c);
            border: none;
            color: #000;
        }
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #bb2d3b);
            border: none;
        }
        .table {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 5px 10px rgba(0,0,0,0.05);
        }
        .table thead th {
            background: var(--light-bg);
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .alert {
            border-radius: var(--border-radius);
            border: none;
        }
        footer {
            margin-top: 50px;
            text-align: center;
            padding: 20px;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('shipments.index') }}">
                <i class="fas fa-shipping-fast me-2"></i> Shipping Label
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer>
        <i class="fas fa-print"></i> Sistem Label Pengiriman &copy; {{ date('Y') }}
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>