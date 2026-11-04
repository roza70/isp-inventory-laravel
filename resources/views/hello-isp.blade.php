<!DOCTYPE html>
<html>
<head>
    <title>ISP Inventory System</title>
</head>
<a href="{{ route('products.index') }}">
    View All Products
</a>
<body>

    <h1>ISP Inventory Management System</h1>

    <h2>Products Page</h2>

    <h3>Product Information</h3>

    <p>Product Name: {{ $productName }}</p>
    <p>Brand: {{ $brand }}</p>
    <p>Type: {{ $type }}</p>

</body>
</html>
