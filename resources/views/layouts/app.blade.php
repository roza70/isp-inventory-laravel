<!DOCTYPE html>
<html>

<head>
    <title>ISP Inventory System</title>
</head>

<body>

    <header>
        <h1>ISP Inventory Management System</h1>
        <nav>
            <a href="{{ route('products.index') }}">Products</a>


            <a href="{{ route('organizations.index') }}">Organizations</a>
            <a href="{{ route('warehouses.index') }}">Warehouses</a>
            <a href="{{ route('devices.index') }}">Devices</a>
            <a href="{{ route('usage-infos.index') }}">Usage History</a>
            <a href="{{ route('usage-infos.create') }}">Issue Device</a>
            <a href="{{ route('stock-receipts.index') }}">Stock Receiving</a>
            <a href="{{ route('router-transactions.index') }}">
                Router Transactions
            </a>
        </nav>
    </header>

    <hr>

    <main>
        @yield('content')
    </main>

    <hr>

    <footer>
        <p>ISP Inventory System © 2026</p>
    </footer>

</body>

</html>