<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Gudeg Yu Yem</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 280px;
            background-color: #8B4513;
            color: white;
            padding: 30px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .admin-sidebar .brand {
            padding: 0 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .admin-sidebar .brand h3 {
            margin: 0;
            font-weight: 700;
            font-size: 20px;
        }

        .admin-sidebar .brand p {
            margin: 5px 0 0;
            font-size: 12px;
            opacity: 0.8;
        }

        .admin-sidebar .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .admin-sidebar .nav-menu li {
            margin: 0;
        }

        .admin-sidebar .nav-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: 0.3s;
            font-size: 14px;
        }

        .admin-sidebar .nav-menu a:hover,
        .admin-sidebar .nav-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .admin-sidebar .nav-menu i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        .admin-sidebar .btn-add-item {
            margin: 20px;
            width: calc(100% - 40px);
            background-color: #D2691E;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        .admin-sidebar .btn-add-item:hover {
            background-color: #B8600F;
        }

        .admin-main {
            margin-left: 280px;
            flex: 1;
            padding: 30px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .admin-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        .admin-date {
            font-size: 14px;
            color: #999;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-processing {
            background-color: #FFE7D0;
            color: #D2691E;
        }

        .status-delivered {
            background-color: #D0E8D0;
            color: #2E7D32;
        }

        .status-cancelled {
            background-color: #FFDDD9;
            color: #C62828;
        }

        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .table-responsive {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        table {
            margin-bottom: 0;
        }

        table thead {
            background-color: #f9f9f9;
        }

        table th {
            border: none;
            padding: 15px;
            font-weight: 600;
            color: #666;
            font-size: 13px;
            text-transform: uppercase;
        }

        table td {
            border: none;
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .order-id {
            font-weight: 600;
            color: #333;
        }

        .customer-name {
            color: #666;
        }

        .text-right {
            text-align: right;
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                width: 250px;
            }

            .admin-main {
                margin-left: 250px;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .admin-wrapper {
                flex-direction: column;
            }

            .admin-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .admin-main {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="brand">
            <h3>Admin Portal</h3>
            <p>Gudeg Yu Yem</p>
        </div>

        <ul class="nav-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.menus.index') }}" class="@if(str_contains(Route::currentRouteName(), 'admin.menus')) active @endif">
                    <i class="fas fa-list"></i>
                    <span>Menu Managemen</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders.index') }}" class="@if(str_contains(Route::currentRouteName(), 'admin.orders')) active @endif">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orderan</span>
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        style="background:none;border:none;width:100%;text-align:left;padding:12px 16px;color:inherit;cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <main class="admin-main">
        <div class="admin-header">
            <h1>@yield('title')</h1>
            <div class="admin-date" id="currentDate"></div>
        </div>

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    const dateElement = document.getElementById('currentDate');
    const today = new Date();
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    dateElement.textContent = '' + today.toLocaleDateString('en-US', options);
</script>

</body>
</html>