<!DOCTYPE html>
<html>
<head>
    <title>ISP Inventory System</title>
</head>
<body>

    <h1>Welcome to {{ $systemName }}</h1>

    <h2>Company: {{ $companyName }}</h2>

    <p>Total Products: {{ $totalProducts }}</p>

    <p>System Status: {{ $systemStatus }}</p>

    @if($isSystemActive)
        <p>System is Running</p>
    <h2>Available Products</h2>

<ul>
    @foreach($products as $product)
        <li>{{ $product }}</li>
    @endforeach
</ul>
    @else
        <p>System is Not Running</p>
    @endif

</body>
</html>
