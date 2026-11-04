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